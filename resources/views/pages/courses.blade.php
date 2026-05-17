@extends('layouts.landing')

@section('title', 'الكورسات | ' . config('app.name'))

@section('styles')
    .course-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .course-card:hover {
        transform: translateY(-10px);
    }
    .image-zoom {
        overflow: hidden;
    }
    .image-zoom img {
        transition: transform 0.5s ease;
    }
    .course-card:hover .image-zoom img {
        transform: scale(1.1);
    }
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="py-20 bg-gradient-to-r from-indigo-600 to-blue-700 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-4xl md:text-6xl font-black mb-6 mt-10">استكشف دوراتنا التعليمية</h1>
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto leading-relaxed">
                مجموعة مختارة من أفضل الكورسات التعليمية المقدمة من نخبة من المعلمين المتميزين.
            </p>
        </div>
    </section>

    <!-- Courses Grid -->
    <section class="py-20 min-h-[60vh]">
        <div class="container mx-auto px-6">
            @if($courses->isEmpty())
                <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-[3rem] shadow-xl border border-slate-100 dark:border-slate-700">
                    <div class="w-24 h-24 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-book-open text-4xl text-slate-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">لا توجد دورات حالياً</h3>
                    <p class="text-slate-500">نحن نعمل على إضافة محتوى جديد قريباً، تابعونا!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($courses as $course)
                        <div class="course-card bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-full">
                            <!-- Course Image -->
                            <div class="relative h-56 image-zoom">
                                @if($course->image)
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-indigo-300 dark:text-slate-500"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 right-4 px-4 py-2 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-xl shadow-lg border border-white/50 dark:border-slate-700/50">
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $course->formatted_price }}</span>
                                </div>
                            </div>

                            <!-- Course Content -->
                            <div class="p-8 flex-grow flex flex-col">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500/10 flex items-center justify-center">
                                        <i class="fas fa-chalkboard-teacher text-xs text-indigo-500"></i>
                                    </div>
                                    <span class="text-sm font-medium text-slate-500 dark:text-slate-400">أ. {{ $course->teacher->name }}</span>
                                </div>

                                <h3 class="text-xl font-extrabold mb-3 line-clamp-2 leading-tight group-hover:text-indigo-500 transition">
                                    {{ $course->title }}
                                </h3>
                                
                                <p class="text-slate-600 dark:text-gray-400 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">
                                    {{ Str::limit(strip_tags($course->description), 120) }}
                                </p>

                                <div class="pt-6 border-t border-slate-50 dark:border-slate-700/50 flex items-center justify-between mt-auto">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-1.5 text-slate-400">
                                            <i class="far fa-play-circle"></i>
                                            <span class="text-xs">{{ $course->lessons_count }} درس</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('pages.courses.show', $course->id) }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-indigo-500/20">
                                        عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-6">
        <div class="container mx-auto max-w-5xl bg-slate-900 dark:bg-indigo-900 text-white rounded-[3rem] p-10 md:p-20 text-center relative overflow-hidden shadow-2xl shadow-indigo-500/20">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black mb-8 leading-tight">ابدأ رحلتك التعليمية اليوم</h2>
                <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto opacity-80">
                    انضم إلى آلاف الطلاب الذين يحققون أهدافهم من خلال دوراتنا التفاعلية والمميزة.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="{{ route('register') }}" class="px-10 py-5 bg-white text-indigo-900 dark:text-indigo-900 font-black rounded-2xl hover:scale-105 transition transform shadow-xl">
                        سجل مجاناً الآن
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
