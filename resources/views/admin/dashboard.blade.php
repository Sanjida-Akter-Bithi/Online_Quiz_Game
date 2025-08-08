<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }} (Role: {{ Auth::user()->role }})</p>

        <div class="mt-6 space-y-4">
            <a href="{{ route('quizzes.create') }}" class="block bg-blue-500 text-white px-4 py-2 rounded">Create Quiz</a>
            <a href="#" class="block bg-green-500 text-white px-4 py-2 rounded">Manage Questions</a>
            <a href="{{ route('profile.edit') }}" class="block bg-gray-500 text-white px-4 py-2 rounded">Edit Profile</a>
        </div>
    </div>
</x-app-layout>
