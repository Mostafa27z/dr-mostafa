@extends('layouts.student')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
        {{ $exam->title }}
    </h1>

    <div class="mb-4">
        <div id="timer" class="text-lg font-semibold p-2 bg-gray-100 inline-block rounded"></div>
    </div>

    <form id="exam-form" method="POST" action="{{ route('student.exams.submit', $exam->id) }}">
        @csrf
        <input type="hidden" name="auto_submit" id="auto_submit" value="0">

        @foreach($exam->questions as $question)
            <div class="mb-6 p-4 border rounded" data-question-id="{{ $question->id }}">
                <h3 class="font-semibold mb-2">{{ $loop->iteration }}. {{ $question->title }}</h3>

                @foreach($question->options as $option)
                    <label class="block mb-1">
                        <input type="radio"
                               name="question_{{ $question->id }}"
                               value="{{ $option->id }}"
                               data-question-id="{{ $question->id }}"
                               data-option-id="{{ $option->id }}"
                               class="option-input mr-2">
                        {{ $option->title }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <div class="mt-6">
            <button id="submit-btn" type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-medium px-6 py-3 rounded-lg shadow-lg transition">
                <i class="fas fa-check ml-2"></i>
                تسليم الامتحان
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
        const startedAt = new Date(data.attempt.started_at);
        const durationSeconds = (data.exam.duration_minutes || 60) * 60;

        const now = new Date();
        const elapsed = Math.max(0, Math.floor((now - startedAt) / 1000));
        remainingSeconds = Math.max(0, durationSeconds - elapsed);

        // استرجاع الإجابات المحفوظة ووضعها في الـ inputs
        const saved = data.saved_answers || {};
        for (const [qId, info] of Object.entries(saved)) {
            if (!info) continue;
            const optionId = info.option_id;
            if (optionId) {
                const input = document.querySelector('input[data-question-id="'+qId+'"][data-option-id="'+optionId+'"]');
                if (input) input.checked = true;
            }
        }

        startCountdown();
    })
    .catch(err => {
        console.error(err);
        // لو فشل جلب البيانات لا توقف الصفحة؛ ضع عدّاد افتراضي
        remainingSeconds = ({{ $exam->duration ?? 60 }}) * 60;
        startCountdown();
    });

    // نص الى عرض من الثواني
    function formatTime(sec) {
        const h = Math.floor(sec / 3600);
        const m = Math.floor((sec % 3600) / 60);
        const s = sec % 60;
        if (h > 0) return `${h}h ${m}m ${s}s`;
        return `${m}m ${s}s`;
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
        timerEl.textContent = 'الوقت المتبقي: ' + formatTime(remainingSeconds);
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
