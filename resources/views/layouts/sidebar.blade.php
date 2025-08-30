<!-- الشريط الجانبي -->
<aside class="sidebar bg-gradient-to-b from-sky-600 to-blue-700 text-white w-64 flex-shrink-0 islamic-pattern hidden md:block" id="sidebar">
    <div class="h-full overflow-y-auto py-4">
        <!-- صورة المستخدم -->
        <div class="px-4 py-6 text-center">
            <div class="mx-auto w-20 h-20 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mb-3 floating">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold">د. مصطفى طنطاوي</h3>
            <p class="text-sm text-white/80">أستاذ المواد الشرعية</p>
        </div>
        
        <!-- قائمة التنقل -->
        <nav class="mt-6">
            <div class="px-4 py-2 text-xs font-semibold text-white/60">القائمة الرئيسية</div>
            
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 mt-1 bg-white/10 border-r-4 border-yellow-400">
                <i class="fas fa-home ml-3"></i>
                <span>لوحة التحكم</span>
            </a>
            
            <a href="{{ route('lessons') }}"class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-book ml-3"></i>
                <span>الدروس</span>
            </a>
            
            <a href="{{ route('sessions') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-video ml-3"></i>
                <span>الحصص</span>
            </a>
            
            <a href="{{ route('groups') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-users ml-3"></i>
                <span>المجموعات</span>
            </a>
            
            <a href="{{ route('exams') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-file-alt ml-3"></i>
                <span>الاختبارات</span>
            </a>
            
            <a href="{{ route('assignments') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-tasks ml-3"></i>
                <span>الواجبات</span>
            </a>
            
            <div class="px-4 py-2 text-xs font-semibold text-white/60 mt-6">الإعدادات</div>
            
            <a href="#" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-cog ml-3"></i>
                <span>الإعدادات</span>
            </a>
            
            <a href="#" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition">
                <i class="fas fa-question-circle ml-3"></i>
                <span>المساعدة</span>
            </a>
            
            <!-- تسجيل الخروج -->
            <form method="POST" action="{{ route('logout') }}" class="mt-6 border-t border-white/20 pt-4">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 mt-1 hover:bg-white/10 transition">
                    <i class="fas fa-sign-out-alt ml-3"></i>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </nav>
    </div>
</aside>

<!-- overlay للجوال -->
<div class="overlay" id="overlay"></div>