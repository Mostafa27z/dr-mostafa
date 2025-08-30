<div class="sidebar bg-gradient-to-b from-sky-600 to-blue-700 text-white w-64 flex-shrink-0 hidden md:block" id="sidebar">
    <div class="h-full overflow-y-auto py-4">
        <div class="px-4 py-6 text-center">
            <div class="mx-auto w-20 h-20 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center mb-3 floating">
                <i class="fas fa-user-graduate text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold">د. مصطفى طنطاوي</h3>
            <p class="text-sm text-white/80">أستاذ المواد الشرعية</p>
        </div>
        <nav class="mt-6">
            <a href="#" class="flex items-center px-4 py-3 mt-1 bg-white/10 border-r-4 border-yellow-400">
                <i class="fas fa-home ml-3"></i> لوحة التحكم
            </a>
            <a href="{{ route('lessons') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition"><i class="fas fa-book ml-3"></i> الدروس</a>
            <a href="{{ route('sessions') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition"><i class="fas fa-video ml-3"></i> الحصص</a>
            <a href="{{ route('groups') }}" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition"><i class="fas fa-users ml-3"></i> المجموعات</a>
            <a href="#" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition"><i class="fas fa-file-alt ml-3"></i> الاختبارات</a>
            <a href="#" class="flex items-center px-4 py-3 mt-1 hover:bg-white/10 transition"><i class="fas fa-tasks ml-3"></i> الواجبات</a>
        </nav>
    </div>
</div>
