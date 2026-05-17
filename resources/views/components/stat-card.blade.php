@props(['color' => 'blue', 'icon' => 'fa-chart-line', 'number' => 0, 'label' => ''])

@php
    $colorClasses = [
        'sky' => 'bg-sky-100 text-sky-600 dark:bg-sky-900/30 dark:text-sky-400',
        'green' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
        'yellow' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400',
        'purple' => 'bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400',
        'blue' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
        'red' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
    ][$color];
@endphp

<div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 border dark:border-slate-700">
    <div class="flex items-center">
        <div class="p-3 rounded-full {{ $colorClasses }}">
            <i class="fas {{ $icon }} text-lg"></i>
        </div>
        <div class="mr-4">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $number }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $label }}</p>
        </div>
    </div>
</div>