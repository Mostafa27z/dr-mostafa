<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Storage::extend('bunnycdn', function ($app, $config) {
            $client = new BunnyCDNClient(
                $config['storage_zone'],
                $config['api_key'],
                $config['region']
            );
            $adapter = new BunnyCDNAdapter($client, $config['pull_zone'] ?? null);
            $filesystem = new Filesystem($adapter);
            return new FilesystemAdapter($filesystem, $adapter, $config);
        });
    }
}
