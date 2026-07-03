@extends('layouts.student')

@section('content')
<!-- Header -->
<div class="sticky top-0 z-50 mb-8 -mx-4 px-4 py-2 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-md">
    <div class="bg-white dark:bg-slate-950 rounded-2xl p-4 border border-gray-100 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 relative overflow-hidden" dir="rtl">
        <div class="flex items-center relative z-10 w-full md:w-auto">
            <div class="bg-primary-50 dark:bg-primary-900/30 rounded-xl p-3 ml-4 flex items-center justify-center text-primary-600 dark:text-primary-400">
                <i class="fas fa-file-signature text-xl"></i>
            </div>
            <div>
                <h1 class="text-lg font-black text-slate-800 dark:text-white leading-tight">{{ $exam->title }}</h1>
                <p class="text-[10px] font-bold text-gray-400 mt-0.5 tracking-wide uppercase">محاولة التقييم الحالية</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3 relative z-10">
            <div id="timerContainer" class="bg-slate-900 dark:bg-primary-500 text-white px-4 py-2 rounded-xl border border-slate-800 dark:border-primary-400 shadow-sm flex items-center gap-3">
                <div class="flex items-center justify-center w-6 h-6 rounded-lg bg-white/10">
                    <i class="far fa-clock text-sm"></i>
                </div>
                <div id="timer" class="text-sm font-black tracking-widest min-w-[100px] text-center">--:--:--</div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto mb-12 text-right" dir="rtl">
    <form id="exam-form" method="POST" action="{{ route('student.exams.submit', $exam->id) }}" class="space-y-6">
        @csrf
        <input type="hidden" name="auto_submit" id="auto_submit" value="0">

        @foreach($exam->questions as $question)
            <div class="bg-white dark:bg-slate-950 border border-gray-100 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden question-card transition-all" data-question-id="{{ $question->id }}">
                <div class="px-6 py-4 border-b border-gray-50 dark:border-slate-900 bg-gray-50/30 dark:bg-slate-900/30 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-primary-500 text-white flex items-center justify-center text-xs font-black shadow-sm">
                        {{ $loop->iteration }}
                    </span>
                    <h3 class="text-sm font-black text-slate-800 dark:text-white leading-relaxed">{{ $question->title }}</h3>
                </div>
                
                <div class="p-6 space-y-3">
                    @foreach($question->options as $option)
                        <label class="relative flex items-center p-4 rounded-xl border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 hover:bg-gray-50 dark:hover:bg-slate-900/50 cursor-pointer transition-all group has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50/30 dark:has-[:checked]:bg-primary-900/10 has-[:checked]:ring-4 has-[:checked]:ring-primary-500/5">
                            <input type="radio"
                                   name="question_{{ $question->id }}"
                                   value="{{ $option->id }}"
                                   data-question-id="{{ $question->id }}"
                                   data-option-id="{{ $option->id }}"
                                   class="option-input peer sr-only">
                            
                            <div class="w-5 h-5 rounded-full border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center mr-0 ml-4 peer-checked:border-primary-500 transition-all shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-primary-500 scale-0 peer-checked:scale-100 transition-transform"></div>
                            </div>
                            
                            <span class="text-xs font-bold text-slate-600 dark:text-gray-300 peer-checked:text-slate-800 dark:peer-checked:text-white transition-colors">
                                {{ $option->title }}
                            </span>
                            
                            <div class="absolute inset-y-0 left-4 flex items-center opacity-0 group-hover:opacity-100 peer-checked:opacity-100 transition-opacity">
                                <i class="fas fa-circle-check text-primary-500 text-sm"></i>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="pt-8 flex flex-col items-center gap-6">
            <div class="w-full h-px bg-gradient-to-l from-transparent via-gray-200 dark:via-slate-800 to-transparent"></div>
            
            <div class="p-6 rounded-2xl bg-orange-50/50 dark:bg-orange-900/10 border border-orange-100 dark:border-orange-800/30 text-center max-w-lg">
                <p class="text-[10px] font-black text-orange-600 dark:text-orange-400 leading-relaxed uppercase tracking-widest mb-1">تنبيه نهائي</p>
                <p class="text-[10px] font-bold text-slate-500 dark:text-gray-400">يرجى التأكد من أنك أجبت على جميع الأسئلة قبل الضغط على زر التسليم أدناه. لا يمكنك التراجع بعد إرسال الإجابات.</p>
            </div>

            <button id="submit-btn" type="submit"
                class="min-w-[280px] bg-primary-600 hover:bg-primary-700 text-white font-black px-12 py-4 rounded-2xl shadow-xl shadow-primary-200 dark:shadow-none transition-all transform active:scale-95 flex items-center justify-center gap-3 text-sm">
                <i class="fas fa-cloud-arrow-up text-base"></i>
                تسليم محاولة الامتحان
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const examId = {{ $exam->id }};
    const attemptDataUrl = "{{ route('student.exams.attempt_data', $exam->id) }}";
    const saveAnswerUrl = "{{ route('student.exams.save_answer', $exam->id) }}";
    const autoSubmitUrl = "{{ route('student.exams.auto_submit', $exam->id) }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const timerEl = document.getElementById('timer');
    let remainingSeconds = null;
    let attemptId = null;
    let countdownInterval = null;

    // جلب بيانات المحاولة والإجابات المحفوظة
    fetch(attemptDataUrl, {
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) throw new Error('Failed to load attempt data');

        attemptId = data.attempt.id;
        remainingSeconds = data.attempt.remaining_seconds;

        // استرجاع الإجابات المحفوظة ووضعها في الـ inputs
        const saved = data.saved_answers || {};
        for (const [qId, info] of Object.entries(saved)) {
            if (!info) continue;
            const optionId = info.option_id;
            if (optionId) {
                const input = document.querySelector('input[data-question-id="'+qId+'"][data-option-id="'+optionId+'"]');
                if (input) {
                    input.checked = true;
                    // تلوين الإجابة المحددة فور الاسترجاع
                    const label = input.closest('label');
                    if (label) {
                        label.classList.add('border-primary-500', 'bg-primary-50/30', 'dark:bg-primary-900/10', 'ring-4', 'ring-primary-500/5');
                    }
                }
            }
        }

        startCountdown();
    })
    .catch(err => {
        console.error(err);
        // لو فشل جلب البيانات لا توقف الصفحة؛ استخدم الوقت الممرر من السيرفر كاحتياط
        remainingSeconds = {{ $duration }};
        startCountdown();
    });

    // نص الى عرض من الثواني (HH:MM:SS)
    function formatTime(sec) {
        const h = Math.floor(sec / 3600);
        const m = Math.floor((sec % 3600) / 60);
        const s = sec % 60;
        
        const displayH = String(h).padStart(2, '0');
        const displayM = String(m).padStart(2, '0');
        const displayS = String(s).padStart(2, '0');
        
        return `${displayH}:${displayM}:${displayS}`;
    }

    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);
        updateTimerDisplay();
        countdownInterval = setInterval(() => {
            remainingSeconds--;
            if (remainingSeconds <= 0) {
                remainingSeconds = 0;
                updateTimerDisplay();
                clearInterval(countdownInterval);
                handleTimeEnd();
            } else {
                updateTimerDisplay();
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        if (remainingSeconds <= 300) { // Less than 5 minutes
            document.getElementById('timerContainer').classList.remove('bg-slate-900', 'dark:bg-primary-500');
            document.getElementById('timerContainer').classList.add('bg-red-600', 'animate-pulse');
        }
        timerEl.textContent = formatTime(remainingSeconds);
    }

    function handleTimeEnd() {
        // عند انتهاء الوقت نُعلِم السيرفر ونسلم الاجابات
        // نضع قيمة auto_submit=1 ثم نرسل POST
        document.getElementById('auto_submit').value = '1';

        fetch(autoSubmitUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ })
        })
        .then(r => r.json())
        .then(resp => {
            if (resp.success && resp.redirect) {
                window.location.href = resp.redirect;
            } else {
                // كحل احتياطي نرسل الفورم العادي
                document.getElementById('exam-form').submit();
            }
        })
        .catch(err => {
            console.error('Auto submit failed', err);
            // كحل احتياطي نرسل الفورم العادي
            document.getElementById('exam-form').submit();
        });
    }

    // استماع لتغيرات الخيارات - حفظ فوري
    document.querySelectorAll('.option-input').forEach(input => {
        input.addEventListener('change', function (e) {
            const qId = this.dataset.questionId;
            const optId = this.dataset.optionId;

            // تحديث المؤشرات البصرية للتحديد الفوري
            const container = this.closest('.p-6');
            if (container) {
                container.querySelectorAll('input[type="radio"]').forEach(radio => {
                    const label = radio.closest('label');
                    if (label) {
                        if (radio.checked) {
                            label.classList.add('border-primary-500', 'bg-primary-50/30', 'dark:bg-primary-900/10', 'ring-4', 'ring-primary-500/5');
                        } else {
                            label.classList.remove('border-primary-500', 'bg-primary-50/30', 'dark:bg-primary-900/10', 'ring-4', 'ring-primary-500/5');
                        }
                    }
                });
            }

            // حفظ عبر AJAX
            fetch(saveAnswerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    question_id: qId,
                    option_id: optId
                })
            })
            .then(res => res.json())
            .then(json => {
                if (!json.success) {
                    console.warn('Failed to autosave answer', json);
                }
            })
            .catch(err => console.error('Autosave error', err));
        });
    });

    // عند الضغط على زر التسليم نسمح بالتصرف العادي (الفورم سترسل)
    // لكن للتأكد: إذا أردت إرسال عبر AJAX بدل الفرم العادي، يمكنك منع الافتراضي وإرسال Fetch ثم إعادة توجيه.

    // منع الطالب من فتح الصفحة في لسانات متعددة وإظهار تحذير/تزامن غير مطلوب
    window.addEventListener('beforeunload', function (e) {
        // يمكنك إرسال إشارة سريعة للسيرفر هنا إن رغبت
    });
});
</script>
@endsection
