<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Create New Quiz</h1>

        @if($errors->any())
            <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('quizzes.store') }}" method="POST">
            @csrf

            {{-- Category Text Input --}}
            <div class="mb-4">
                <label class="block font-semibold">Category</label>
                <input
                    type="text"
                    name="category_name"
                    class="border rounded w-full p-2"
                    value="{{ old('category_name') }}"
                    placeholder="e.g. Science/Physics"
                    required
                >
            </div>

            {{-- Difficulty Dropdown --}}
            <div class="mb-4">
                <label class="block font-semibold">Difficulty</label>
                <select name="difficulty" class="border rounded w-full p-2" required>
                    @foreach(['easy', 'medium', 'hard'] as $level)
                        <option value="{{ $level }}" {{ old('difficulty', 'easy') == $level ? 'selected' : '' }}>
                            {{ ucfirst($level) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Quiz Title --}}
            <div class="mb-4">
                <label class="block font-semibold">Quiz Title</label>
                <input
                    type="text"
                    name="title"
                    class="border rounded w-full p-2"
                    value="{{ old('title') }}"
                    required
                >
            </div>

            {{-- Quiz Description --}}
            <div class="mb-4">
                <label class="block font-semibold">Quiz Description</label>
                <textarea name="description" class="border rounded w-full p-2">{{ old('description') }}</textarea>
            </div>

            {{-- Questions with Options --}}
            @for($i = 1; $i <= 5; $i++)
                <div class="mb-4 border p-4 rounded">
                    <label class="block font-semibold">Question {{ $i }}</label>
                    <input
                        type="text"
                        name="questions[{{ $i }}][question_text]"
                        class="border rounded w-full p-2 mb-2"
                        value="{{ old('questions.'.$i.'.question_text') }}"
                        placeholder="Enter question"
                        required
                    >

                    <label class="block mb-1">Options:</label>
                    @for($j = 1; $j <= 4; $j++)
                        <div class="flex items-center mb-2">
                            <input
                                type="text"
                                name="questions[{{ $i }}][options][{{ $j }}][option_text]"
                                class="border rounded mr-2 p-1 flex-1"
                                value="{{ old('questions.'.$i.'.options.'.$j.'.option_text') }}"
                                placeholder="Option {{ $j }}"
                                required
                            >
                            <label class="mr-2 flex items-center">
                                <input
                                    type="radio"
                                    name="questions[{{ $i }}][correct_option]"
                                    value="{{ $j }}"
                                    {{ old('questions.'.$i.'.correct_option') == $j ? 'checked' : '' }}
                                >
                                <span class="ml-1">Correct?</span>
                            </label>
                        </div>
                    @endfor
                </div>
            @endfor

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Create Quiz
            </button>
        </form>
    </div>
</x-app-layout>
