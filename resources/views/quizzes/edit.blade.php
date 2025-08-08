<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Quiz</h1>

        {{-- Display validation errors, if any --}}
        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Category --}}
            <div class="mb-4">
                <label class="block font-semibold">Category</label>
                <input
                    type="text"
                    name="category_name"
                    class="border rounded w-full p-2"
                    value="{{ old('category_name', $quiz->category->name ?? '') }}"
                    placeholder="e.g. Science/Physics"
                    required
                >
            </div>

            {{-- Difficulty --}}
            <div class="mb-4">
                <label class="block font-semibold">Difficulty</label>
                <select name="difficulty" class="border rounded w-full p-2" required>
                    @foreach(['easy', 'medium', 'hard'] as $level)
                        <option value="{{ $level }}"
                            {{ old('difficulty', $quiz->difficulty) == $level ? 'selected' : '' }}>
                            {{ ucfirst($level) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Title --}}
            <div class="mb-4">
                <label class="block font-semibold">Quiz Title</label>
                <input
                    type="text"
                    name="title"
                    class="border rounded w-full p-2"
                    value="{{ old('title', $quiz->title) }}"
                    required
                >
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block font-semibold">Quiz Description</label>
                <textarea name="description" class="border rounded w-full p-2" rows="4">{{ old('description', $quiz->description) }}</textarea>
            </div>

            {{-- Questions & Options --}}
            <h2 class="text-lg font-bold mt-8 mb-3">Questions</h2>
            @foreach($quiz->questions as $qIndex => $question)
                <div class="mb-4 border p-4 rounded bg-gray-50">
                    {{-- Question --}}
                    <label class="block font-semibold mb-1">
                        Question {{ $qIndex + 1 }}
                    </label>
                    <input
                        type="text"
                        name="questions[{{ $question->id }}][question_text]"
                        class="border rounded w-full p-2 mb-2"
                        value="{{ old('questions.'.$question->id.'.question_text', $question->question_text) }}"
                        required
                    >

                    {{-- Options --}}
                    <label class="block mb-1 font-medium">Options:</label>
                    @foreach($question->options as $option)
                        <div class="flex items-center mb-2">
                            <input
                                type="text"
                                name="questions[{{ $question->id }}][options][{{ $option->id }}][option_text]"
                                class="border rounded mr-2 p-1 flex-1"
                                value="{{ old('questions.'.$question->id.'.options.'.$option->id.'.option_text', $option->option_text) }}"
                                required
                                placeholder="Option"
                            >
                            {{-- Only one correct answer selectable per question (radio) --}}
                            <label class="mr-2 flex items-center">
                                <input
                                    type="radio"
                                    name="questions[{{ $question->id }}][correct_option]"
                                    value="{{ $option->id }}"
                                    {{ ($option->is_correct || old('questions.'.$question->id.'.correct_option') == $option->id) ? 'checked' : '' }}
                                >
                                <span class="ml-1 text-sm">Correct</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            {{-- END Questions & Options --}}

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Update Quiz
            </button>
        </form>
    </div>
</x-app-layout>
