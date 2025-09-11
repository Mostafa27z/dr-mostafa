<!-- الشريط الجانبي -->
<aside class="sidebar bg-gradient-to-b from-sky-600 to-blue-700 text-white w-64 flex-shrink-0 islamic-pattern hidden md:block" id="sidebar">
    <div class="h-full overflow-y-auto">
        <!-- Close button for mobile -->
        <div class="md:hidden flex justify-between items-center p-4 border-b border-white/20">
            <h3 class="text-lg font-semibold">القائمة</h3>
            <button onclick="closeSidebar()" class="text-white hover:text-yellow-300 transition p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- صورة المستخدم -->
        <div class="px-4 py-4 sm:py-6 text-center">
            <div class="mx-auto w-16 sm:w-20 h-16 sm:h-20 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mb-3 floating">
                <i class="fas fa-user-graduate text-xl sm:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold">د. مصطفى طنطاوي</h3>
            <p class="text-xs sm:text-sm text-white/80">أستاذ المواد الشرعية</p>
        </div>
        
        <!-- قائمة التنقل -->
        <nav class="mt-4 sm:mt-6 pb-6">
            <div class="px-4 py-2 text-xs font-semibold text-white/60">القائمة الرئيسية</div>
            
            <a href="{{ route('dashboard') }}" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 bg-white/10 border-r-4 border-yellow-400 text-sm sm:text-base">
                <i class="fas fa-home ml-3 w-5"></i>
                <span>لوحة التحكم</span>
            </a>
            
            <a href="{{ route('lessons.index') }}" onclick="closeSidebar()"
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-book ml-3 w-5"></i>
                <span>الدروس</span>
            </a>
            
            <a href="{{ route('sessions.index') }}" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-video ml-3 w-5"></i>
                <span>الحصص</span>
            </a>
            
            <a href="{{ route('teacher.groups.index') }}" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-users ml-3 w-5"></i>
                <span>المجموعات</span>
            </a>
            
            <a href="{{ route('exams.index') }}" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-file-alt ml-3 w-5"></i>
                <span>الاختبارات</span>
            </a>
            
            <a href="{{ route('assignments.index') }}" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-tasks ml-3 w-5"></i>
                <span>الواجبات</span>
            </a>
            
            <div class="px-4 py-2 text-xs font-semibold text-white/60 mt-4 sm:mt-6">الإعدادات</div>
            
            <a href="#" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-cog ml-3 w-5"></i>
                <span>الإعدادات</span>
            </a>
            
            <a href="#" onclick="closeSidebar()" 
               class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                <i class="fas fa-question-circle ml-3 w-5"></i>
                <span>المساعدة</span>
            </a>
            
            <!-- تسجيل الخروج -->
            <div class="mt-4 sm:mt-6 border-t border-white/20 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" onclick="closeSidebar()" 
                            class="flex items-center w-full px-4 py-3 mt-1 hover:bg-white/10 transition duration-200 text-sm sm:text-base">
                        <i class="fas fa-sign-out-alt ml-3 w-5"></i>
                        <span>تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>