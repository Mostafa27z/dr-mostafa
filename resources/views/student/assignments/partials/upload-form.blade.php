{{-- فورم رفع حل الواجب --}}
<form action="{{ route('student.assignments.submit', $assignment->id) }}"
      method="POST" enctype="multipart/form-data"
      class="space-y-4">
    @csrf

    <div>
        <label class="block text-gray-700 font-semibold mb-2">إجابة نصية</label>
        <textarea name="answer_text" rows="4"
                  class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-indigo-200"
                  placeholder="اكتب إجابتك هنا..."></textarea>
    </div>

    <div>
        <label class="block text-gray-700 font-semibold mb-2">رفع ملف</label>
        <input type="file" name="answer_file"
               class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring focus:ring-indigo-200">
        <p class="text-xs text-gray-500 mt-1">الحد الأقصى 5MB</p>
    </div>

    <button type="submit"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        تسليم الواجب
    </button>
</form>
