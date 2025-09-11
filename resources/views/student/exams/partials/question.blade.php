<!-- Question Component -->
<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-md hover:shadow-lg transition mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">
        {{ $loop->iteration }}. {{ $question->title }}
    </h3>

    @if(isset($question->options) && $question->options->count() > 0)
        <div class="space-y-3">
            @foreach($question->options as $option)
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="radio" name="answers[{{ $question->id }}]"
                           value="{{ $option->id }}"
                           class="form-radio text-primary-500 focus:ring-primary-500">
                    <span class="text-gray-700">{{ $option->title }}</span>
                </label>
            @endforeach
        </div>
    @else
        <textarea name="answers[{{ $question->id }}]" rows="4"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 text-sm"
                  placeholder="اكتب إجابتك هنا..."></textarea>
    @endif
</div>
