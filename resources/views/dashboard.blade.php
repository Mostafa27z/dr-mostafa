<x-layout>
    <div class="flex">
        <x-sidebar/>
        <div class="flex-1 overflow-hidden">
            <x-navbar/>
            <div class="p-6">
                <x-welcome-card/>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <x-stat-card color="sky" icon="fa-book" number="24" label="درس نشط"/>
                    <x-stat-card color="green" icon="fa-users" number="156" label="طالب مسجل"/>
                    <x-stat-card color="yellow" icon="fa-file-alt" number="8" label="اختبار نشط"/>
                    <x-stat-card color="purple" icon="fa-tasks" number="32" label="واجب معلق"/>
                </div>
                <x-quick-access>
                    <!-- تضيف هنا روابط الوصول السريع -->
                </x-quick-access>
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
                    <x-activities :activities="$activities ?? collect()" />
                    <x-homeworks  :homeworks="$homeworks ?? collect()" />

                </div>
            </div>
        </div>
    </div>
</x-layout>
