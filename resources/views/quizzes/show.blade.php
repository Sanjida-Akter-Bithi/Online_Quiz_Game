<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }}</h1>

        <div class="mb-2">
            <strong>Category:</strong> {{ $quiz->category->name ?? 'N/A' }}
        </div>
        <div class="mb-2">
            <strong>Difficulty:</strong> {{ ucfirst($quiz->difficulty) }}
        </div>
        <div class="mb-4">
            <strong>Description:</strong> {{ $quiz->description }}
        </div>

        {{-- Questions and Options --}}
        @if($quiz->questions->count())
            <h2 class="text-xl font-semibold mt-6 mb-2">Questions</h2>
            @foreach ($quiz->questions as $index => $question)
                <div class="mb-3 p-3 border rounded">
                    <div class="font-semibold mb-1">
                        Q{{ $index+1 }}: {{ $question->question_text }}
                    </div>
                    @if($question->options->count())
                        <ul class="list-disc ml-6">
                            @foreach ($question->options as $option)
                                <li class="mb-1">
                                    {{ $option->option_text }}
                                    @if($option->is_correct)
                                        <span class="text-green-600 font-bold ml-2">(Correct)</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-red-500 ml-6">No options found for this question.</div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="text-gray-600">No questions found for this quiz.</div>
        @endif

        <a href="{{ route('quizzes.index') }}"
           class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Back to All Quizzes
        </a>
    </div>
</x-app-layout>
