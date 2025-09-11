<!-- Timer Component -->
<div id="exam-timer" class="flex items-center justify-center bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl px-6 py-3 shadow-lg">
    <i class="fas fa-clock text-xl ml-2"></i>
    <span class="font-bold text-lg" id="timer-text">00:00:00</span>
</div>

@push('scripts')
<script>
    function startTimer(duration, display) {
        let timer = duration, hours, minutes, seconds;
        const interval = setInterval(function () {
            hours   = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours   = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = hours + ":" + minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(interval);
                alert("انتهى وقت الامتحان ⏰ سيتم تسليم إجابتك الآن.");
                document.getElementById("exam-form")?.submit();
            }
        }, 1000);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const duration = {{ $duration ?? 3600 }}; // المدة بالثواني (افتراضي ساعة)
        const display = document.querySelector('#timer-text');
        if (display) startTimer(duration, display);
    });
</script>
@endpush
