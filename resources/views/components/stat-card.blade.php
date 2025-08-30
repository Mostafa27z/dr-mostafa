<div class="dashboard-card bg-white rounded-2xl shadow-md p-6 border-l-4 border-{{ $color }}-500 fade-in">
    <div class="flex items-center">
        <div class="p-3 bg-{{ $color }}-100 rounded-full">
            <i class="fas {{ $icon }} text-{{ $color }}-600 text-xl"></i>
        </div>
        <div class="mr-3">
            <h3 class="text-2xl font-bold">{{ $number }}</h3>
            <p class="text-gray-500">{{ $label }}</p>
        </div>
    </div>
</div>
