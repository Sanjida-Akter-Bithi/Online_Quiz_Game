<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Create New Quiz</h1>

        {{-- Success message --}}
        @if(session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Quiz Creation Form --}}
        <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold mb-1">Quiz Title</label>
                <input type="text" name="title" class="w-full border border-gray-300 p-2 rounded" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-bold mb-1">Description</label>
                <textarea name="description" class="w-full border border-gray-300 p-2 rounded"></textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Save Quiz
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
