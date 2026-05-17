{{-- فورم رفع حل الواجب --}}
<form action="{{ route('student.assignments.submit', $assignment->id) }}"
      method="POST" enctype="multipart/form-data"
      class="space-y-6">
    @csrf

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest mr-1">الإجابة النصية (اختياري)</label>
        <textarea name="answer_text" rows="5"
                  class="w-full px-4 py-3 border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 text-slate-700 dark:text-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm font-bold"
                  placeholder="اكتب إجابتك هنا..."></textarea>
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest mr-1">رفع ملف الحل (اختياري)</label>
        <div class="relative group">
            <input type="file" name="answer_file"
                   class="block w-full text-xs text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-950 rounded-xl cursor-pointer focus:outline-none focus:ring-2 focus:ring-primary-500/10 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
        </div>
        <p class="text-[10px] font-bold text-gray-400 mt-2 flex items-center">
            <i class="fas fa-circle-info ml-1.5 text-primary-500"></i>
            أقصى حجم للملف المسموح به هو 5 ميجابايت (PDF, JPG, PNG)
        </p>
    </div>

    <button type="submit"
            class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl text-xs font-black transition-all shadow-sm shadow-primary-200 dark:shadow-none inline-flex items-center justify-center">
        <i class="fas fa-paper-plane ml-2"></i> تأكيد تسليم الواجب
    </button>
</form>
