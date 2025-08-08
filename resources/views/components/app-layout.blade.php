<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Bar (Optional) -->
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ url('/') }}" class="text-lg font-bold">Quiz App</a>
            <div>
                @auth
                    <span class="mr-4">Hello, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 px-3 py-1 rounded">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto py-6 px-4">
        {{ $slot }}
    </main>
</body>
</html>
