@extends('layouts.landing')

@section('title', 'قريباً - انضم كمعلم | ' . config('app.name'))

@section('styles')
    .floating { animation: floating 4s ease-in-out infinite; }
    @keyframes floating { 0% { transform: translateY(0); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0); } }
@endsection

@section('content')
    <main class="min-h-[80vh] flex items-center justify-center p-4 md:p-6 text-center">
        <div class="max-w-2xl w-full bg-white dark:bg-slate-800 rounded-2xl md:rounded-[3rem] shadow-2xl p-6 md:p-16 border border-slate-200 dark:border-slate-700 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute -top-12 md:-top-24 -right-12 md:-right-24 w-48 md:w-64 h-48 md:h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 md:-bottom-24 -left-12 md:-left-24 w-48 md:w-64 h-48 md:h-64 bg-cyan-500/10 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center justify-center w-20 md:w-24 h-20 md:h-24 bg-indigo-500/20 rounded-2xl md:rounded-3xl mb-6 md:mb-8 floating text-indigo-500">
                    <i class="fas fa-rocket text-3xl md:text-4xl"></i>
                </div>
                
                <h1 class="text-2xl md:text-5xl font-extrabold mb-4 md:mb-6 leading-tight">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-cyan-500">قريباً جداً</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 dark:text-gray-300 mb-8 md:mb-10 leading-relaxed">
                    نحن نعمل بجد على تطوير بوابة المعلمين لتوفير أفضل تجربة تعليمية. 
                    <br class="hidden md:block">
                    ترقبوا الانطلاق قريباً لاستكشاف أدواتنا المتطورة في إدارة المجموعات والطلاب.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:bg-indigo-700 hover:scale-105 transition transform duration-300">
                        <i class="fas fa-home ml-1 md:ml-2"></i> العودة للرئيسية
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
