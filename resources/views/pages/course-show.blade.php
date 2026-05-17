@extends('layouts.landing')

@section('title', $course->title . ' | ' . config('app.name'))

@section('styles')
    .hero-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    }
    .card-shadow {
        box-shadow: 0 10px 50px -12px rgba(0, 0, 0, 0.1);
    }
@endsection

@section('content')
    <!-- Hero Header -->
    <section class="hero-gradient py-20 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-2/3 text-right">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-md rounded-full mb-6 border border-white/30">
                        <i class="fas fa-chalkboard-teacher text-sm"></i>
                        <span class="text-sm font-bold">أ. {{ $course->teacher->name }}</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">{{ $course->title }}</h1>
                    <p class="text-xl text-indigo-100 max-w-2xl leading-relaxed mb-8">
                        {{ Str::limit(strip_tags($course->description), 200) }}
                    </p>
                    
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-book-open text-indigo-300"></i>
                            <span>{{ $course->lessons->count() }} درس</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-money-bill-wave text-emerald-300"></i>
                            <span>{{ $course->formatted_price }}</span>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/3 w-full">
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-[2.5rem] shadow-2xl card-shadow">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-auto rounded-[2rem] shadow-lg">
                        @else
                            <div class="w-full aspect-video bg-slate-100 dark:bg-slate-700 rounded-[2rem] flex items-center justify-center">
                                <i class="fas fa-image text-5xl text-slate-300"></i>
                            </div>
                        @endif
                        
                        <div class="mt-8 px-4 pb-4">
                            @guest
                                <a href="{{ route('login') }}" class="block w-full text-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition shadow-xl shadow-indigo-500/20">
                                    سجل دخول للانضمام
                                </a>
                            @else
                                @if(Auth::user()->role === 'student')
                                    @if($enrollment)
                                        @if($enrollment->status === 'approved')
                                            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl text-center font-bold border border-emerald-100 dark:border-emerald-800">
                                                <i class="fas fa-check-circle ml-2"></i> أنت منضم لهذه الدورة
                                                <a href="{{ route('student.courses.show', $course->id) }}" class="block mt-2 text-sm underline">انتقل لصفحة الدورة</a>
                                            </div>
                                        @elseif($enrollment->status === 'pending')
                                            <div class="p-4 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl text-center font-bold border border-blue-100 dark:border-blue-800">
                                                <i class="fas fa-hourglass-half ml-2"></i> في انتظار الموافقة
                                            </div>
                                        @else
                                            <div class="p-4 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-2xl text-center font-bold border border-red-100 dark:border-red-800 mb-4">
                                                <i class="fas fa-times-circle ml-2"></i> تم رفض طلبك
                                            </div>
                                            <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="block w-full text-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition shadow-xl shadow-indigo-500/20">
                                                    إعادة إرسال طلب الانضمام
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <form action="{{ route('enrollments.store', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="block w-full text-center py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition shadow-xl shadow-indigo-500/20">
                                                انضم للدورة الآن
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="p-4 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl text-center font-bold border border-amber-100 dark:border-amber-800 text-sm">
                                        <i class="fas fa-exclamation-triangle ml-2"></i> هذا الحساب مخصص للمعلمين، يجب تسجيل الدخول كطالب للاتحاق بالدورة.
                                    </div>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Details Section -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Description -->
                <div class="lg:col-span-2 space-y-12">
                    <div class="bg-white dark:bg-slate-800 p-10 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-align-right text-indigo-500"></i>
                            عن الدورة
                        </h2>
                        <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-gray-300 leading-relaxed">
                            {!! nl2br(e($course->description)) !!}
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-800 p-10 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700">
                        <h2 class="text-2xl font-bold mb-8 flex items-center gap-3">
                            <i class="fas fa-tasks text-emerald-500"></i>
                            محتوى الدورة
                        </h2>
                        <div class="space-y-4">
                            @forelse($course->lessons as $lesson)
                                <div class="flex items-center justify-between p-5 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-600 group hover:border-indigo-300 dark:hover:border-indigo-700 transition">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-indigo-500 shadow-sm border border-slate-100 dark:border-slate-700 group-hover:bg-indigo-500 group-hover:text-white transition">
                                            <i class="fas fa-play text-xs"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 dark:text-white">{{ $lesson->title }}</h4>
                                            @if($lesson->duration)
                                                <span class="text-xs text-slate-400">{{ $lesson->duration }} دقيقة</span>
                                            @endif
                                        </div>
                                    </div>
                                    <i class="fas fa-lock text-slate-300 dark:text-slate-600 text-sm"></i>
                                </div>
                            @empty
                                <div class="text-center py-10 opacity-50">
                                    <p>سيتم إضافة الدروس قريباً</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700">
                            <h3 class="text-xl font-bold mb-6">معلومات المعلم</h3>
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-indigo-500 flex items-center justify-center text-white text-2xl font-black">
                                    {{ mb_substr($course->teacher->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold">{{ $course->teacher->name }}</h4>
                                    <span class="text-sm text-slate-500">معلم معتمد</span>
                                </div>
                            </div>
                            <p class="text-sm text-slate-400 leading-relaxed italic">
                                "نحن هنا لمساعدتك في الوصول إلى أهدافك التعليمية من خلال محتوى متميز ومتابعة مستمرة."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
