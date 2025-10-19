<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    private string $user_ip;

    public function __construct()
    {
        $this->user_ip = trim(file_get_contents('https://api.ipify.org'));
    }

    private function sign_bcdn_url($name, $is_directory_token = false, $path_allowed = NULL, $countries_allowed = NULL, $countries_blocked = NULL, $referers_allowed = NULL)
    {    
        $url = env('BUNNYCDN_PULL_ZONE') . $name;
        $securityKey = env('BUNNYCDN_PULL_ZONE_API_KEY');
        $expiration_time = 10800;
        $user_ip = $this->user_ip;

        if(!is_null($countries_allowed))
        {
            $url .= (parse_url($url, PHP_URL_QUERY) == "") ? "?" : "&";
            $url .= "token_countries={$countries_allowed}";
        }
        if(!is_null($countries_blocked))
        {
            $url .= (parse_url($url, PHP_URL_QUERY) == "") ? "?" : "&";
            $url .= "token_countries_blocked={$countries_blocked}";
        }
        if(!is_null($referers_allowed))
        {
            $url .= (parse_url($url, PHP_URL_QUERY) == "") ? "?" : "&";
            $url .= "token_referer={$referers_allowed}";
        }

        $url_scheme = parse_url($url, PHP_URL_SCHEME);
        $url_host = parse_url($url, PHP_URL_HOST);
        $url_path = parse_url($url, PHP_URL_PATH);
        $url_query = parse_url($url, PHP_URL_QUERY);


        $parameters = array();
        parse_str($url_query, $parameters);

        // Check if the path is specified and ovewrite the default
        $signature_path = $url_path;

        if(!is_null($path_allowed))
        {
            $signature_path = $path_allowed;
            $parameters["token_path"] = $signature_path;
        }

        // Expiration time
        $expires = time() + $expiration_time; 

        // Construct the parameter data
        ksort($parameters); // Sort alphabetically, very important
        $parameter_data = "";
        $parameter_data_url = "";
        if(sizeof($parameters) > 0)
        {
            foreach ($parameters as $key => $value) 
            {
                if(strlen($parameter_data) > 0)
                    $parameter_data .= "&";

                $parameter_data_url .= "&";

                $parameter_data .= "{$key}=" . $value;
                $parameter_data_url .= "{$key}=" . urlencode($value); // URL encode everything but slashes for the URL data
            }
        }

        // Generate the toke
        $hashableBase = $securityKey.$signature_path.$expires;

        // If using IP validation
        if(!is_null($user_ip))
        {
            $hashableBase .= $user_ip;
        }

        $hashableBase .= $parameter_data;

        // Generate the token
        $token = hash('sha256', $hashableBase, true);
        $token = base64_encode($token);
        $token = strtr($token, '+/', '-_');
        $token = str_replace('=', '', $token); 

        if($is_directory_token)
            {
            return "{$url_scheme}://{$url_host}{$url_path}?token={$token}{$parameter_data_url}&expires={$expires}";
        }
        else 
            {
            return "{$url_scheme}://{$url_host}/bcdn_token={$token}&expires={$expires}{$parameter_data_url}{$url_path}";
        }
    }

    public function stream($path, Request $request)
    {
     
        $location = session('location');
        $user_ip = $this->user_ip;
        $client_ip = $request->ip();
        if ($location !== env('LOCATION') && $client_ip !== $user_ip) {
            abort(403, 'Forbidden');
        }
        session()->forget('location');

        $secureUrl = $this->sign_bcdn_url($path);
                
        // Get video headers first
        $headers = get_headers($secureUrl, 1);
        
        if (!$headers || !isset($headers['Content-Length'])) {
            abort(404, 'Video not found');
        }
        
        $contentLength = $headers['Content-Length'];
        $contentType = $headers['Content-Type'];
        
        // Handle range requests for video seeking
        $range = $request->header('Range');
        if ($range) {
            return $this->handleRangeRequest($secureUrl, $range, $contentLength);
        }
        
        // Stream the video
        return response()->stream(function() use ($secureUrl) {
            $stream = fopen($secureUrl, 'r');
            if ($stream) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $contentType,
            'Content-Length' => $contentLength,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

    private function handleRangeRequest($url, $range, $contentLength)
    {
        // Parse range header (e.g., "bytes=0-1023")
        preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
        $start = intval($matches[1]);
        $end = $matches[2] ? intval($matches[2]) : $contentLength - 1;
        
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Range: bytes={$start}-{$end}\r\n"
            ]
        ]);
        
        $stream = fopen($url, 'r', false, $context);
        
        return response()->stream(function() use ($stream) {
            if ($stream) {
                fpassthru($stream);
                fclose($stream);
            }
        }, 206, [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Range' => "bytes {$start}-{$end}/{$contentLength}",
            'Content-Length' => ($end - $start + 1),
        ]);
    }
}