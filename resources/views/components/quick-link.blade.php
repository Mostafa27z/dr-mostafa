@props(['icon' => 'fa-link', 'label' => 'رابط', 'url' => '#'])

<a href="{{ $url }}" class="flex flex-col items-center p-4 bg-gray-50 dark:bg-slate-700/50 rounded-lg hover:bg-blue-50 dark:hover:bg-slate-700 transition-colors border dark:border-slate-600">
    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-2">
        <i class="fas {{ $icon }} text-blue-600 dark:text-blue-400"></i>
    </div>
    <span class="text-sm text-gray-700 dark:text-gray-300 text-center">{{ $label }}</span>
</a>