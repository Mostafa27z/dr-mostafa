@props(['color' => 'blue', 'icon' => 'fa-chart-line', 'number' => 0, 'label' => ''])

@php
    $colorClasses = [
        'sky' => 'bg-sky-100 text-sky-600',
        'green' => 'bg-green-100 text-green-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'purple' => 'bg-purple-100 text-purple-600',
        'blue' => 'bg-blue-100 text-blue-600',
        'red' => 'bg-red-100 text-red-600'
    ][$color];
@endphp

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center">
        <div class="p-3 rounded-full {{ $colorClasses }}">
            <i class="fas {{ $icon }} text-lg"></i>
        </div>
        <div class="mr-4">
            <h3 class="text-2xl font-bold text-gray-800">{{ $number }}</h3>
            <p class="text-sm text-gray-500">{{ $label }}</p>
        </div>
    </div>
</div>