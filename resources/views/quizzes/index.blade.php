<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Manage Quizzes</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-2 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Create New Quiz --}}
        <a href="{{ route('quizzes.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
            + Create New Quiz
        </a>

        {{-- Filter Form --}}
        <form method="GET" action="{{ route('quizzes.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2 sm:gap-4">
            <select name="category_id" class="border rounded px-2 py-1">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <select name="difficulty" class="border rounded px-2 py-1">
                <option value="">All Difficulties</option>
                @foreach(['easy', 'medium', 'hard'] as $level)
                    <option value="{{ $level }}" {{ request('difficulty') == $level ? 'selected' : '' }}>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-600 text-white rounded px-3 py-1">Filter</button>
            <a href="{{ route('quizzes.index') }}" class="bg-gray-300 text-black rounded px-3 py-1">Reset</a>
        </form>

        @if($quizzes->count())
            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Title</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Category</th>
                        <th class="py-2 px-4 border-b">Difficulty</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $quiz->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $quiz->title }}</td>
                            <td class="py-2 px-4 border-b">{{ $quiz->description }}</td>
                            <td class="py-2 px-4 border-b">{{ $quiz->category->name ?? '-' }}</td>
                            <td class="py-2 px-4 border-b">{{ ucfirst($quiz->difficulty) }}</td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex flex-wrap gap-1">
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="px-2 py-1 bg-green-500 text-white rounded">View</a>
                                    <a href="{{ route('quizzes.edit', $quiz) }}" class="px-2 py-1 bg-yellow-400 text-black rounded">Edit</a>
                                    <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1 bg-red-500 text-white rounded"
                                            onclick="return confirm('Are you sure you want to delete this quiz?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $quizzes->links() }}
            </div>
        @else
            <div class="text-gray-500 mt-6">No quizzes found.</div>
        @endif
    </div>
</x-app-layout>
