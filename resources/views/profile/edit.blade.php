@php
    $user = auth()->user();
    $layout = 'layouts.app'; // Default

    if ($user->role === 'teacher') {
        $layout = 'layouts.teacher';
    } elseif ($user->role === 'student') {
        $layout = 'layouts.student';
    }
@endphp

@extends($layout)

@section('title', 'الملف الشخصي')
@section('page-title', 'إعدات الحساب والخصوصية')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 text-right pb-12">
    <!-- Header Summary -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 rounded-[2.5rem] p-8 md:p-12 text-white shadow-xl relative overflow-hidden flex items-center justify-between">
        <div class="relative z-10">
            <h2 class="text-3xl font-black mb-3">إعدادات ملفك الشخصي</h2>
            <p class="text-primary-100 font-bold text-sm max-w-md">تحكم في بياناتك الأساسية، كلمة المرور، وتفضيلات الأمان الخاصة بحسابك.</p>
        </div>
        <div class="hidden md:flex w-20 h-20 bg-white/10 rounded-3xl items-center justify-center text-3xl backdrop-blur-md border border-white/20">
            <i class="fas fa-user-gear"></i>
        </div>
    </div>

    <!-- Forms Container -->
    <div class="space-y-8 px-4 md:px-0">
        <!-- Update Profile Info -->
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-8 md:p-12 border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative group">
            <div class="absolute top-0 right-12 w-24 h-1 bg-primary-500 rounded-b-full"></div>
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="bg-white dark:bg-slate-950 rounded-[2.5rem] p-8 md:p-12 border border-gray-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow relative group">
            <div class="absolute top-0 right-12 w-24 h-1 bg-amber-500 rounded-b-full"></div>
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account (Optional/Danger Zone) -->
        <div class="bg-rose-50/50 dark:bg-rose-950/10 rounded-[2.5rem] p-8 md:p-12 border border-rose-100 dark:border-rose-900/30 shadow-sm relative group">
            <div class="absolute top-0 right-12 w-24 h-1 bg-rose-500 rounded-b-full"></div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
