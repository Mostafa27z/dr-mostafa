@props(['icon' => 'fa-link', 'label' => 'رابط', 'url' => '#'])

<a href="{{ $url }}" class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 transition-colors">
    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
        <i class="fas {{ $icon }} text-blue-600"></i>
    </div>
    <span class="text-sm text-gray-700 text-center">{{ $label }}</span>
</a>