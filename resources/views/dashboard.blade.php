<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">
            @if(Auth::user()->role == 'admin')
                Admin Dashboard
            @else
                Player Dashboard
            @endif
        </h1>
        <p>
            WELCOME, {{ Auth::user()->name }} 
            (
                @if(Auth::user()->role == 'admin')
                    <strong>Admin</strong>
                @else
                    <strong>Player</strong>
                @endif
            )
        </p>

        <div class="mt-6 space-y-4">
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('quizzes.create') }}" class="block bg-blue-500 text-white px-4 py-2 rounded">Create Quiz</a>
                <a href="{{ route('quizzes.index') }}" class="block bg-green-500 text-white px-4 py-2 rounded">Manage Quizzes</a>
                <!-- Add other Admin-only dashboard links here -->
            @else
                <a href="#" class="block bg-blue-500 text-white px-4 py-2 rounded">Take a Quiz</a>
                <a href="#" class="block bg-green-500 text-white px-4 py-2 rounded">View Scores</a>
                <!-- Add Student-only dashboard links here -->
            @endif

            <!-- FIXED BELOW: View/Edit Profile link uses profile.index -->
            <a href="{{ route('profile.index') }}" class="block bg-gray-500 text-white px-4 py-2 rounded">View/Edit Profile</a>
        </div>
    </div>
</x-app-layout>
