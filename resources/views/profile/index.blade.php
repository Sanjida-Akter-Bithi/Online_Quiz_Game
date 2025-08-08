<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">My Profile</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>

        <div class="mt-4">
            <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Profile</a>
        </div>
    </div>
</x-app-layout>
