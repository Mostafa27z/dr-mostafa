<nav class="bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <button class="md:hidden text-xl mr-4" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="flex-shrink-0 flex items-center">
                    <i class="fas fa-graduation-cap text-2xl ml-2"></i>
                    <span class="text-xl font-semibold">منصة الدكتور مصطفى طنطاوي</span>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-4 space-x-reverse">
                <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition">
                    <i class="fas fa-user-circle ml-2"></i> مرحباً، د. مصطفى
                </a>
                <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition">
                    <i class="fas fa-cog ml-2"></i> الإعدادات
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 transition">
                        <i class="fas fa-sign-out-alt ml-2"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
<div class="overlay" id="overlay"></div>
