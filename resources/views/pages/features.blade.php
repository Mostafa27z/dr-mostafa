@extends('layouts.landing')

@section('title', 'مميزات المنصة | ' . config('app.name'))

@section('styles')
    .feature-card { transition: all 0.3s ease; }
    .feature-card:hover { transform: translateY(-5px); }
@endsection

@section('content')
    <!-- Header -->
    <header class="py-12 md:py-20 bg-gradient-to-r from-indigo-600 to-indigo-800 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <h1 class="text-3xl md:text-6xl font-black mb-4 md:mb-6 mt-6 md:mt-10">مميزات المنصة</h1>
            <p class="text-lg md:text-xl text-indigo-100 max-w-2xl mx-auto leading-relaxed">
                اكتشف الأدوات والحلول التقنية التي نقدمها لتسهيل العملية التعليمية ورفع كفاءة التعلم.
            </p>
        </div>
    </header>

    <main class="container mx-auto px-4 md:px-6 py-12 md:py-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-12">
            
            <!-- 1. Courses & Lessons -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-book-open text-3xl text-indigo-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">إدارة الكورسات والدروس</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    تنظيم المحتوى التعليمي في كورسات مقسمة إلى دروس، مع دعم كامل لرفع الملفات، الفيديوهات، والوصف التفصيلي لكل درس لمسيرة تعليمية منظمة.
                </p>
            </div>

            <!-- 2. Study Groups -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-cyan-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-users text-3xl text-cyan-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">مجموعات دراسية خاصة</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    إمكانية إنشاء مجموعات دراسية مخصصة وربطها بالطلاب، مما يتيح للمعلم التحكم الكامل في من يحصل على المحتوى والمتابعة الخاصة لكل مجموعة.
                </p>
            </div>

            <!-- 3. Electronic Exams -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-file-signature text-3xl text-emerald-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">اختبارات إلكترونية ذكية</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    نظام امتحانات متكامل يدعم الأسئلة المتعددة وتحديد الوقت، مع ميزة التصحيح التلقائي وعرض النتائج الفورية لتقييم سريع ودقيق لمستوى الطلاب.
                </p>
            </div>

            <!-- 4. Assignments -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-tasks text-3xl text-amber-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">إدارة الواجبات والمهام</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    إسناد مهام منزلية للطلاب، ومتابعة تسليماتهم وتصحيحها وتقديم التغذية الراجعة، لضمان استمرارية التطبيق العملي لما يتم تعلمه في الدروس.
                </p>
            </div>

            <!-- 5. Scheduled Sessions -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-rose-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-calendar-alt text-3xl text-rose-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">حصص وجلسات مجدولة</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    تنظيم المواعيد الدراسية وتذكير الطلاب بها، مما يساعد في خلق بيئة دراسية ملتزمة ومنظمة تشبه الفصول الدراسية الحقيقية بفاعلية رقمية.
                </p>
            </div>

            <!-- 6. Direct Chat -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-comments text-3xl text-blue-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">تواصل مباشر وتفاعلي</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    نظام مراسلة فوري يربط المعلم بالطالب، مما يسهل الرد على الاستفسارات، النقاش حول المحتوى، وخلق جو تفاعلي يكسر حواجز التعليم عن بعد.
                </p>
            </div>

            <!-- 7. Tracking -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-chart-pie text-3xl text-purple-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">متابعة دقيقة للأداء</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    لوحة تحكم إحصائية توضح مدى تقدم الطالب في الدروس ودرجاته في الاختبارات، مما يساعد المعلم والوالدين على التدخل لتحسين النتائج.
                </p>
            </div>

            <!-- 8. Video Streaming -->
            <div class="feature-card bg-white dark:bg-slate-800 p-6 md:p-8 rounded-2xl md:rounded-[2.5rem] shadow-xl border border-slate-100 dark:border-slate-700">
                <div class="w-16 h-16 bg-slate-500/10 rounded-2xl flex items-center justify-center mb-6">
                    <i class="fas fa-video text-3xl text-slate-500"></i>
                </div>
                <h3 class="text-2xl font-bold mb-4">بث المحتوى المرئي</h3>
                <p class="text-slate-600 dark:text-gray-400 leading-relaxed">
                    دعم كامل لتشغيل الفيديوهات التعليمية (بما في ذلك منصة YouTube) داخل المنصة بشكل آمن يمنع التشتت ويضمن التركيز على المحتوى.
                </p>
            </div>

        </div>

        <div class="mt-24 text-center">
            <h2 class="text-3xl font-bold mb-8">هل أنت مستعد للبدء؟</h2>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" class="px-10 py-5 bg-indigo-600 text-white font-bold rounded-2xl shadow-2xl hover:bg-indigo-700 hover:scale-105 transition transform">
                    ابدأ الآن كطالب
                </a>
                <a href="{{ route('pages.how-to-register-teacher') }}" class="px-10 py-5 bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 font-bold rounded-2xl border-2 border-indigo-600 dark:border-indigo-400 hover:scale-105 transition transform">
                    انضم كمعلم
                </a>
            </div>
        </div>
    </main>
@endsection
