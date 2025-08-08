<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold">Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="border p-2 w-full rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="border p-2 w-full rounded" required>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save Changes</button>
            <a href="{{ route('profile.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
        </form>
    </div>
</x-app-layout>
