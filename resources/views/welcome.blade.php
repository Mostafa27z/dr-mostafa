@extends('layouts.landing')

{{-- No title override needed as layout uses app.name by default --}}

@section('styles')
    .pulse-slow {
        animation: pulse-slow 8s linear infinite;
    }
    
    @keyframes pulse-slow {
        0%, 100% { transform: scale(1); opacity: 0.1; }
        50% { transform: scale(1.1); opacity: 0.2; }
    }
    
    .flip-card {
        perspective: 1000px;
        height: 16rem;
    }
    
    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.8s;
        transform-style: preserve-3d;
    }
    
    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }
    
    .flip-card-front, .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        border-radius: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    
    .flip-card-back {
        transform: rotateY(180deg);
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    }
    
    .grid-pattern {
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
    }
    
    .testimonial-card {
        opacity: 0;
        transition: opacity 0.5s ease;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .testimonial-card.active {
        opacity: 1;
    }
    
    .nav-dot {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .nav-dot.active {
        transform: scale(1.5);
        background-color: white;
    }
    
    @media (max-width: 768px) {
        .flip-card {
            height: 12rem;
            margin-bottom: 1rem;
        }
        .flip-card-front i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .flip-card-front h3 {
            font-size: 1.25rem;
        }
    }
@endsection

@section('content')
    <main class="container mx-auto px-4 py-8 flex flex-col items-center">

        <!-- العنوان الرئيسي -->
        <div class="text-center fade-in mb-12 md:mb-20 mt-8 md:mt-16 relative px-2">
            <div class="absolute -top-10 md:-top-20 right-1/2 translate-x-1/2 w-48 md:w-64 h-48 md:h-64 bg-indigo-500/10 rounded-full blur-3xl -z-10 pulse-slow"></div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-extrabold mb-4 md:mb-6 leading-tight drop-shadow-lg text-slate-900 dark:text-white">
                طور مهاراتك مع <br class="hidden sm:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-cyan-500 dark:from-indigo-400 dark:to-cyan-400">{{ config('app.name') }}</span>
            </h1>
            <p class="text-lg md:text-xl mb-10 text-slate-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed">
                المنصة المتكاملة للتعلم الرقمي التي تضع بين يديك أحدث الدروس، التمارين التفاعلية، 
                والمتابعة الدقيقة لمسيرتك التعليمية للوصول إلى أقصى طموحاتك.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                @auth
                    <a href="{{ Auth::user()->role === 'teacher' ? route('teacher.dashboard') : route('student.home') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-500/20 hover:scale-105 transition transform duration-300 flex items-center justify-center border border-indigo-500/30">
                        <i class="fas fa-th-large ml-2"></i>
                        انتقل إلى لوحة التحكم
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-500/20 hover:scale-105 transition transform duration-300 flex items-center justify-center border border-indigo-500/30">
                        <i class="fas fa-user-plus ml-2"></i>
                        ابدأ رحلتك التعليمية مجاناً
                    </a>
                    <a href="{{ route('pages.courses') }}" class="px-8 py-4 bg-slate-800 text-white font-bold rounded-2xl shadow-xl hover:scale-105 transition transform duration-300 flex items-center justify-center border border-slate-700">
                        <i class="fas fa-play ml-2 text-indigo-400"></i>
                        استكشف الكورسات
                    </a>
                @endauth
            </div>
        </div>

        <!-- المميزات الحقيقية للمنصة -->
        <div id="features-section" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 w-full max-w-6xl mb-24 px-4">
            <div class="bg-white dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 p-6 rounded-3xl text-center shadow-md dark:shadow-none">
                <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-book-open text-indigo-400 text-xl"></i>
                </div>
                <h3 class="font-bold mb-2">كورسات ودروس</h3>
                <p class="text-sm text-gray-500">تنظيم الكورسات إلى دروس متنوعة مع دعم كامل للمحتوى التعليمي المرئي.</p>
            </div>
            <div class="bg-white dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 p-6 rounded-3xl text-center shadow-md dark:shadow-none">
                <div class="w-14 h-14 bg-cyan-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-users text-cyan-400 text-xl"></i>
                </div>
                <h3 class="font-bold mb-2">مجموعات دراسية</h3>
                <p class="text-sm text-gray-500">بيئة مخصصة لكل معلم لإنشاء مجموعات دراسية وإدارة طلابه بكفاءة.</p>
            </div>
            <div class="bg-white dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 p-6 rounded-3xl text-center shadow-md dark:shadow-none">
                <div class="w-14 h-14 bg-emerald-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-file-alt text-emerald-400 text-xl"></i>
                </div>
                <h3 class="font-bold mb-2">اختبارات إلكترونية</h3>
                <p class="text-sm text-gray-500">نظام اختبارات متكامل يدعم أسئلة الاختيار من متعدد مع تصحيح فوري.</p>
            </div>
            <div class="bg-white dark:bg-slate-800/50 backdrop-blur-sm border border-slate-200 dark:border-slate-700/50 p-6 rounded-3xl text-center shadow-md dark:shadow-none">
                <div class="w-14 h-14 bg-amber-500/20 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-pencil-alt text-amber-400 text-xl"></i>
                </div>
                <h3 class="font-bold mb-2">واجبات ومهام</h3>
                <p class="text-sm text-gray-500">إسناد واجبات للطلاب واستلام الحلول وتقييمها من خلال المنصة.</p>
            </div>
        </div>

        <!-- المجالات الدراسية -->
        <section class="w-full max-w-6xl mb-24">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900 dark:text-white">منظومة تعليمية متكاملة</h2>
                <div class="w-20 h-1.5 bg-indigo-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-lg dark:shadow-none">
                            <div class="text-5xl mb-6 text-indigo-500 dark:text-indigo-400"><i class="fas fa-chalkboard-teacher"></i></div>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">بوابة المعلم</h3>
                            <p class="text-slate-500 dark:text-gray-400 mt-2">تحكم كامل في المجموعات والمحتوى</p>
                        </div>
                        <div class="flip-card-back">
                            <h3 class="text-2xl font-bold mb-4 text-white">بوابة المعلم</h3>
                            <p class="text-center text-indigo-100 italic">"أدوات متطورة لرفع الدروس، إنشاء الامتحانات، ومتابعة الطلاب في مكان واحد."</p>
                        </div>
                    </div>
                </div>
                
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-lg dark:shadow-none">
                            <div class="text-5xl mb-6 text-cyan-500 dark:text-cyan-400"><i class="fas fa-user-graduate"></i></div>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">رحلة الطالب</h3>
                            <p class="text-slate-500 dark:text-gray-400 mt-2">تعلم، طبق، وتفوق</p>
                        </div>
                        <div class="flip-card-back bg-gradient-to-br from-cyan-600 to-cyan-800">
                            <h3 class="text-2xl font-bold mb-4 text-white">رحلة الطالب</h3>
                            <p class="text-center text-cyan-50 italic">"مشاهدة الدروس، حل الواجبات، واجتياز الاختبارات مع الحصول على نتائج فورية."</p>
                        </div>
                    </div>
                </div>
                
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-lg dark:shadow-none">
                            <div class="text-5xl mb-6 text-emerald-500 dark:text-emerald-400"><i class="fas fa-shield-alt"></i></div>
                            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">حماية وتفاعل</h3>
                            <p class="text-slate-500 dark:text-gray-400 mt-2">بيئة تعليمية آمنة ومغلقة</p>
                        </div>
                        <div class="flip-card-back bg-gradient-to-br from-emerald-600 to-emerald-800">
                            <h3 class="text-2xl font-bold mb-4 text-white">حماية وتفاعل</h3>
                            <p class="text-center text-emerald-50 italic">"دروس محمية، وتواصل مباشر داخل المجموعات لضمان أفضل تجربة تعليمية."</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- كيف تبدأ رحلتك؟ -->
        <section class="w-full max-w-6xl mb-32">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-slate-900 dark:text-white">كيف تبدأ رحلتك؟</h2>
                <div class="w-20 h-1.5 bg-indigo-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative p-6 text-center">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-600 text-indigo-600 dark:text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-white dark:border-slate-900 z-10 relative shadow-md dark:shadow-none">1</div>
                    <div class="hidden md:block absolute top-12 left-0 w-full h-0.5 bg-slate-200 dark:bg-slate-800 -z-0"></div>
                    <h4 class="font-bold mb-2 text-slate-900 dark:text-white">أنشئ حسابك</h4>
                    <p class="text-sm text-slate-600 dark:text-gray-500">سجل حساباً جديداً كطالب لتتمكن من الوصول للمحتوى.</p>
                </div>
                <div class="relative p-6 text-center">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-600 text-indigo-600 dark:text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-white dark:border-slate-900 z-10 relative shadow-md dark:shadow-none">2</div>
                    <div class="hidden md:block absolute top-12 left-0 w-full h-0.5 bg-slate-200 dark:bg-slate-800 -z-0"></div>
                    <h4 class="font-bold mb-2 text-slate-900 dark:text-white">انضم لمجموعة</h4>
                    <p class="text-sm text-slate-600 dark:text-gray-500">اطلب الانضمام للمجموعات الدراسية المتاحة لتبدأ التعلم.</p>
                </div>
                <div class="relative p-6 text-center">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-600 text-indigo-600 dark:text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-white dark:border-slate-900 z-10 relative shadow-md dark:shadow-none">3</div>
                    <div class="hidden md:block absolute top-12 left-0 w-full h-0.5 bg-slate-200 dark:bg-slate-800 -z-0"></div>
                    <h4 class="font-bold mb-2 text-slate-900 dark:text-white">ذاكر وناقش</h4>
                    <p class="text-sm text-slate-600 dark:text-gray-500">تابع الدروس وتواصل مع معلمك عبر نظام الدردشة المدمج.</p>
                </div>
                <div class="relative p-6 text-center">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-600 text-indigo-600 dark:text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4 border-4 border-white dark:border-slate-900 z-10 relative shadow-md dark:shadow-none">4</div>
                    <h4 class="font-bold mb-2 text-slate-900 dark:text-white">اختبر نفسك</h4>
                    <p class="text-sm text-slate-600 dark:text-gray-500">قم بحل الواجبات والاختبارات لقياس مدى استيعابك للمواد.</p>
                </div>
            </div>
        </section>

        <!-- آراء الطلاب -->
        <section class="w-full max-w-4xl mb-32 bg-white/60 dark:bg-slate-800/40 p-12 rounded-[3rem] border border-slate-200 dark:border-slate-700/30 shadow-lg dark:shadow-none overflow-hidden h-96 relative">
            <h2 class="text-3xl font-bold text-center mb-16 text-slate-900 dark:text-white">ماذا يقول طلابنا؟</h2>
            <div class="relative h-32">
                <div class="testimonial-card active flex flex-col items-center justify-center">
                    <p class="text-center text-xl md:text-2xl italic mb-8 text-slate-700 dark:text-gray-200">"أفضل ميزة في المنصة هي سهولة الوصول للدروس والواجبات في مكان واحد."</p>
                </div>
                
                <div class="testimonial-card flex flex-col items-center justify-center">
                    <p class="text-center text-xl md:text-2xl italic mb-8 text-slate-700 dark:text-gray-200">"ساعدتني الاختبارات الإلكترونية على تثبيت المعلومة ومعرفة نتيجتي فور الانتهاء."</p>
                </div>
            </div>
            <div class="flex justify-center space-x-4 space-x-reverse mt-12 absolute bottom-12 left-0 w-full">
                <button class="nav-dot w-2 h-2 bg-indigo-300 dark:bg-white/30 rounded-full active" data-index="0"></button>
                <button class="nav-dot w-2 h-2 bg-slate-300 dark:bg-white/30 rounded-full" data-index="1"></button>
            </div>
        </section>

        <!-- CONTACT FORM -->
        <section id="contact-section" class="w-full max-w-5xl mb-32">
            <div class="bg-indigo-600 rounded-[3rem] p-8 md:p-16 relative overflow-hidden shadow-2xl shadow-indigo-500/20">
                <div class="absolute top-0 left-0 w-full h-full grid-pattern opacity-10"></div>
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl md:text-5xl font-bold mb-6 text-white text-right">هل لديك استفسار؟</h2>
                        <p class="text-indigo-100 text-lg mb-8 text-right">نحن هنا لمساعدتك في كل خطوة. اترك لنا رسالة وسنقوم بالرد عليك في أقرب وقت ممكن.</p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 text-white">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <span>support@lms-platform.com</span>
                            </div>
                            <div class="flex items-center gap-4 text-white">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <span>+20 123 456 7890</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 md:p-8">
                        <form id="contact-form" class="space-y-4" novalidate>
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="name" id="name" placeholder="الاسم الكامل" required
                                        class="w-full px-5 py-3 rounded-2xl bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 text-white">
                                    <p class="mt-1 text-xs text-red-200 hidden" id="error-name"></p>
                                </div>
                                <div>
                                    <input type="text" name="phone" id="phone" placeholder="رقم الهاتف"
                                        class="w-full px-5 py-3 rounded-2xl bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 text-white">
                                    <p class="mt-1 text-xs text-red-200 hidden" id="error-phone"></p>
                                </div>
                            </div>
                            <div>
                                <input type="text" name="title" id="title" placeholder="موضوع الرسالة" required
                                    class="w-full px-5 py-3 rounded-2xl bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 text-white">
                                <p class="mt-1 text-xs text-red-200 hidden" id="error-title"></p>
                            </div>
                            <div>
                                <textarea name="content" id="content" rows="4" placeholder="كيف يمكننا مساعدتك؟" required
                                    class="w-full px-5 py-3 rounded-2xl bg-white/10 border border-white/20 placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 text-white"></textarea>
                                <p class="mt-1 text-xs text-red-200 hidden" id="error-content"></p>
                            </div>
                            <button type="submit" id="contact-submit"
                                class="w-full py-4 bg-white text-indigo-600 font-bold rounded-2xl hover:bg-gray-100 transition shadow-lg">
                                إرسال الرسالة
                            </button>

                            <div id="contact-success" class="hidden p-4 rounded-xl bg-green-500 text-white text-center font-medium"></div>
                            <div id="contact-fail" class="hidden p-4 rounded-xl bg-red-500 text-white text-center font-medium"></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // testimonial slider
            const testimonials = document.querySelectorAll('.testimonial-card');
            const dots = document.querySelectorAll('.nav-dot');
            let currentIndex = 0;
            
            function showTestimonial(index) {
                if (testimonials.length === 0) return;
                testimonials.forEach(testimonial => testimonial.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                
                testimonials[index].classList.add('active');
                dots[index].classList.add('active');
                currentIndex = index;
            }
            
            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.getAttribute('data-index'));
                    showTestimonial(index);
                });
            });
            
            if (testimonials.length > 1) {
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % testimonials.length;
                    showTestimonial(currentIndex);
                }, 5000);
            }
            
            // Contact form handling
            const contactForm = document.getElementById('contact-form');
            if (contactForm) {
                const submitBtn = document.getElementById('contact-submit');
                const successBox = document.getElementById('contact-success');
                const failBox = document.getElementById('contact-fail');
                const errors = {
                    name: document.getElementById('error-name'),
                    phone: document.getElementById('error-phone'),
                    title: document.getElementById('error-title'),
                    content: document.getElementById('error-content'),
                };
                const postUrl = "{{ route('contact.store') }}";

                contactForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    successBox.classList.add('hidden'); failBox.classList.add('hidden');
                    Object.values(errors).forEach(n => { if (n) { n.classList.add('hidden'); n.textContent = ''; } });

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-2"></i> جارٍ الإرسال';

                    const formData = new FormData(contactForm);
                    const payload = Object.fromEntries(formData.entries());

                    try {
                        const res = await fetch(postUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        const data = await res.json();

                        if (res.ok && data.success) {
                            successBox.textContent = data.message || 'تم إرسال رسالتك بنجاح.';
                            successBox.classList.remove('hidden');
                            contactForm.reset();
                        } else if (res.status === 422) {
                            const v = data.errors || data;
                            if (v.name && errors.name) { errors.name.textContent = v.name[0]; errors.name.classList.remove('hidden'); }
                            if (v.phone && errors.phone) { errors.phone.textContent = v.phone[0]; errors.phone.classList.remove('hidden'); }
                            if (v.title && errors.title) { errors.title.textContent = v.title[0]; errors.title.classList.remove('hidden'); }
                            if (v.content && errors.content) { errors.content.textContent = v.content[0]; errors.content.classList.remove('hidden'); }
                            failBox.textContent = 'برجاء تصحيح الأخطاء الظاهرة أعلاه.';
                            failBox.classList.remove('hidden');
                        } else {
                            failBox.textContent = data.message || 'حدث خطأ أثناء الإرسال، حاول لاحقاً.';
                            failBox.classList.remove('hidden');
                        }
                    } catch (err) {
                        failBox.textContent = 'حدث خطأ في الاتصال. تأكد من اتصالك بالإنترنت.';
                        failBox.classList.remove('hidden');
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'إرسال الرسالة';
                    }
                });
            }
        });
    </script>
@endsection
