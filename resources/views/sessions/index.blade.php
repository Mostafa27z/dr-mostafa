<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            <i class="fas fa-video ml-2"></i>
            إدارة الجلسات
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <!-- العنوان الرئيسي -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white mb-6">
                <h1 class="text-2xl font-bold mb-2">إدارة الجلسات</h1>
                <p class="opacity-90">هنا يمكنك إدارة جميع الجلسات المباشرة والمواعيد الأسبوعية</p>
            </div>

            <!-- محتوى الصفحة -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- عمود إضافة جلسة جديدة -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                            <h5 class="text-white text-xl font-semibold">إضافة جلسة جديدة</h5>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('sessions.store') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium">عنوان الجلسة *</label>
                                        <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل عنوان الجلسة" required>
                                        @error('title')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium">وصف الجلسة</label>
                                        <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="أدخل وصف الجلسة">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium">موعد الجلسة *</label>
                                        <input type="datetime-local" name="time" value="{{ old('time') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                        @error('time')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium">رابط الجلسة</label>
                                        <input type="url" name="link" value="{{ old('link') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" placeholder="https://zoom.us/j/123456789">
                                        @error('link')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700 mb-2 font-medium">المجموعة *</label>
                                        <select name="group_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                            <option value="">اختر مجموعة</option>
                                            @foreach($groups as $group)
                                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                                    {{ $group->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('group_id')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="pt-4">
                                        <button type="submit" class="w-full px-6 py-3 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition-colors duration-200 flex items-center justify-center">
                                            <i class="fas fa-plus-circle ml-2"></i>
                                            إضافة الجلسة
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- عمود الجلسات -->
                <div class="lg:col-span-2">
                    <!-- جدول الجلسات القادمة -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-6">
                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                            <h5 class="text-white text-xl font-semibold">الجلسات القادمة</h5>
                            <div class="relative">
                                <input type="text" placeholder="بحث..." class="px-4 py-2 rounded-xl bg-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50">
                                <i class="fas fa-search absolute left-3 top-3 text-white/70"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($sessions->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-right">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-4 py-3">الجلسة</th>
                                            <th class="px-4 py-3">المجموعة</th>
                                            <th class="px-4 py-3">الموعد</th>
                                            <th class="px-4 py-3">الرابط</th>
                                            <th class="px-4 py-3">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sessions as $session)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-3 font-medium">{{ $session->title }}</td>
                                            <td class="px-4 py-3">
                                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">{{ $session->group->title }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center">
                                                    <i class="far fa-clock text-purple-500 ml-2"></i>
                                                    <span>{{ $session->time }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($session->link)
                                                <a href="{{ $session->link }}" target="_blank" class="text-blue-500 hover:text-blue-700 flex items-center">
                                                    <i class="fas fa-link ml-2"></i>
                                                    انضم الآن
                                                </a>
                                                @else
                                                <span class="text-gray-500">لا يوجد رابط</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex space-x-2 space-x-reverse">
                                                    <a href="{{ route('sessions.edit', $session) }}" class="text-blue-500 hover:text-blue-700" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('sessions.show', $session) }}" class="text-green-500 hover:text-green-700" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('sessions.destroy', $session) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذه الجلسة؟')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $sessions->links() }}
                            </div>
                            @else
                            <div class="text-center py-8">
                                <i class="fas fa-video text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">لا توجد جلسات حتى الآن</p>
                            </div>
                            @endif
                        </div>
                    </div>

                   <!-- تقويم الجلسات -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
        <h5 class="text-white text-xl font-semibold">جدول الجلسات الأسبوعي</h5>
    </div>
    <div class="p-6">
        <!-- فلترة الأيام -->
        <div class="flex overflow-x-auto space-x-2 space-x-reverse pb-4 mb-4" id="day-filters">
            <button class="day-filter-btn px-4 py-2 bg-purple-500 text-white rounded-lg whitespace-nowrap transition-all duration-200" data-day="all">الكل</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Saturday">السبت</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Sunday">الأحد</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Monday">الاثنين</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Tuesday">الثلاثاء</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Wednesday">الأربعاء</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Thursday">الخميس</button>
            <button class="day-filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg whitespace-nowrap hover:bg-gray-300 transition-all duration-200" data-day="Friday">الجمعة</button>
        </div>

        <!-- عدد الجلسات المعروضة -->
        <div class="mb-4">
            <p class="text-sm text-gray-600">
                عرض <span id="visible-sessions-count">{{ $sessions->count() }}</span> من <span id="total-sessions-count">{{ $sessions->count() }}</span> جلسة
            </p>
        </div>

        <!-- جدول الجلسات -->
        <div class="overflow-x-auto">
            <table class="w-full text-right">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-3 text-right">اليوم</th>
                        <th class="px-4 py-3 text-right">الجلسة</th>
                        <th class="px-4 py-3 text-right">الموعد</th>
                        <th class="px-4 py-3 text-right">المجموعة</th>
                        <th class="px-4 py-3 text-right">الحالة</th>
                        <th class="px-4 py-3 text-right">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="sessions-table-body">
                    @php
                        $arabicDays = [
                            'Saturday' => 'السبت',
                            'Sunday' => 'الأحد', 
                            'Monday' => 'الاثنين',
                            'Tuesday' => 'الثلاثاء',
                            'Wednesday' => 'الأربعاء',
                            'Thursday' => 'الخميس',
                            'Friday' => 'الجمعة'
                        ];
                        $colors = ['blue', 'green', 'yellow', 'red', 'purple', 'indigo', 'pink'];
                    @endphp
                    
                    @foreach($sessions as $index => $session)
                    @php
                        // Convert string to Carbon date if needed
                        $sessionTime = is_string($session->time) ? \Carbon\Carbon::parse($session->time) : $session->time;
                        $sessionDayName = $sessionTime->format('l'); // English day name
                        $arabicDay = $arabicDays[$sessionDayName] ?? $sessionDayName;
                        $colorIndex = array_search($sessionDayName, array_keys($arabicDays)) ?: 0;
                        $color = $colors[$colorIndex];
                    @endphp
                    <tr class="session-row border-b hover:bg-gray-50 transition-colors duration-150" data-day="{{ $sessionDayName }}" data-arabic-day="{{ $arabicDay }}">
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <span class="bg-{{ $color }}-100 text-{{ $color }}-800 px-2 py-1 rounded-full text-xs ml-2 min-w-max">
                                    {{ $arabicDay }}
                                </span>
                                <span class="text-sm">{{ $sessionTime->format('d/m') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div>
                                <p class="font-medium">{{ $session->title }}</p>
                                {{-- @if($session->description)
                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($session->description, 40) }}</p>
                                @endif --}}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center">
                                <i class="far fa-clock text-purple-500 ml-2"></i>
                                <div>
                                    <p class="font-medium">{{ $sessionTime->format('H:i') }}</p>
                                    <p class="text-xs text-gray-500">{{ $sessionTime->format('Y-m-d') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">
                                {{ $session->group->title ?? 'غير محدد' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $sessionTime = is_string($session->time) ? \Carbon\Carbon::parse($session->time) : $session->time;
                                $now = now();
                            @endphp
                            @if($sessionTime > $now)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                    <i class="fas fa-clock ml-1"></i>
                                    قادمة
                                </span>
                            @elseif($sessionTime->isToday())
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                    <i class="fas fa-circle ml-1"></i>
                                    اليوم
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                    <i class="fas fa-check ml-1"></i>
                                    انتهت
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1 space-x-reverse">
                                @if($session->link)
                                <a href="{{ $session->link }}" target="_blank" class="text-green-500 hover:text-green-700 p-2 rounded-lg hover:bg-green-50 transition-all duration-200" title="الانضمام للجلسة">
                                    <i class="fas fa-video"></i>
                                </a>
                                @endif
                                <a href="{{ route('sessions.edit', $session) }}" class="text-blue-500 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('sessions.show', $session) }}" class="text-purple-500 hover:text-purple-700 p-2 rounded-lg hover:bg-purple-50 transition-all duration-200" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('sessions.destroy', $session) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition-all duration-200" title="حذف" onclick="return confirm('هل أنت متأكد من حذف هذه الجلسة؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- رسالة عند عدم وجود جلسات -->
        <div id="no-sessions-message" class="text-center py-8 hidden">
            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-calendar-times text-2xl text-gray-400"></i>
            </div>
            <p class="text-gray-500">لا توجد جلسات في هذا اليوم</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dayFilterButtons = document.querySelectorAll('.day-filter-btn');
    const sessionRows = document.querySelectorAll('.session-row');
    const visibleSessionsCount = document.getElementById('visible-sessions-count');
    const totalSessionsCount = document.getElementById('total-sessions-count');
    const noSessionsMessage = document.getElementById('no-sessions-message');
    const tableBody = document.getElementById('sessions-table-body');

    // Map Arabic days to English for filtering
    const dayMapping = {
        'السبت': 'Saturday',
        'الأحد': 'Sunday',
        'الاثنين': 'Monday',
        'الثلاثاء': 'Tuesday',
        'الأربعاء': 'Wednesday',
        'الخميس': 'Thursday',
        'الجمعة': 'Friday'
    };

    function updateSessionCount() {
        const visibleRows = document.querySelectorAll('.session-row:not(.hidden)');
        visibleSessionsCount.textContent = visibleRows.length;
        
        // Show/hide no sessions message
        if (visibleRows.length === 0) {
            noSessionsMessage.classList.remove('hidden');
            tableBody.classList.add('hidden');
        } else {
            noSessionsMessage.classList.add('hidden');
            tableBody.classList.remove('hidden');
        }
    }

    function filterSessionsByDay(selectedDay) {
        sessionRows.forEach(row => {
            if (selectedDay === 'all') {
                row.classList.remove('hidden');
                row.style.display = '';
            } else {
                const rowDay = row.getAttribute('data-day');
                if (rowDay === selectedDay) {
                    row.classList.remove('hidden');
                    row.style.display = '';
                } else {
                    row.classList.add('hidden');
                    row.style.display = 'none';
                }
            }
        });
        
        updateSessionCount();
    }

    function setActiveButton(activeButton) {
        // Reset all buttons
        dayFilterButtons.forEach(btn => {
            btn.classList.remove('bg-purple-500', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
        });
        
        // Activate selected button
        activeButton.classList.remove('bg-gray-200', 'text-gray-700');
        activeButton.classList.add('bg-purple-500', 'text-white');
    }

    // Add click event listeners to day filter buttons
    dayFilterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedDay = this.getAttribute('data-day');
            
            // Update button styles
            setActiveButton(this);
            
            // Filter sessions
            filterSessionsByDay(selectedDay);
            
            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Initialize with all sessions visible
    updateSessionCount();

    // Add hover effects for table rows
    sessionRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
            this.style.boxShadow = 'none';
        });
    });

    // Highlight current day button on page load
    const today = new Date();
    const todayName = today.toLocaleDateString('en-US', { weekday: 'long' });
    const todayButton = document.querySelector(`[data-day="${todayName}"]`);
    
    if (todayButton) {
        // Add subtle indication for today's button
        todayButton.style.boxShadow = '0 0 0 2px rgba(139, 92, 246, 0.3)';
    }

    // Auto-scroll to current time sessions
    const currentTime = new Date();
    sessionRows.forEach(row => {
        const sessionTimeText = row.querySelector('.fa-clock').parentElement.textContent.trim();
        // You could add logic here to highlight current/next session
    });
});

// Additional utility functions
function highlightUpcomingSessions() {
    const now = new Date();
    const nextHour = new Date(now.getTime() + 60 * 60 * 1000);
    
    sessionRows.forEach(row => {
        const timeElement = row.querySelector('[data-time]');
        if (timeElement) {
            const sessionTime = new Date(timeElement.getAttribute('data-time'));
            if (sessionTime > now && sessionTime <= nextHour) {
                row.classList.add('bg-yellow-50', 'border-yellow-200');
                row.querySelector('.session-row').insertAdjacentHTML('afterbegin', 
                    '<div class="absolute -right-2 top-1/2 transform -translate-y-1/2 w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>'
                );
            }
        }
    });
}

// Call highlight function
setTimeout(highlightUpcomingSessions, 500);
</script>

<style>
.session-row {
    position: relative;
    transition: all 0.2s ease;
}

.day-filter-btn {
    min-width: fit-content;
    user-select: none;
}

.day-filter-btn:active {
    transform: scale(0.95);
}

/* Animation for filtered content */
.session-row.hidden {
    opacity: 0;
    transform: translateY(-10px);
}

.session-row:not(.hidden) {
    opacity: 1;
    transform: translateY(0);
}

/* Pulse animation for active sessions */
@keyframes pulse-subtle {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.upcoming-session {
    animation: pulse-subtle 2s infinite;
}
</style>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>