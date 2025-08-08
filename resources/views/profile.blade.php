@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Profile Dashboard</h1>
    @if(session('success'))
      <div style="color: green">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"><br>
        @error('name') <div style="color: red">{{ $message }}</div> @enderror

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"><br>
        @error('email') <div style="color: red">{{ $message }}</div> @enderror

        <label>New Password (leave blank if not changing):</label><br>
        <input type="password" name="password"><br>
        @error('password') <div style="color: red">{{ $message }}</div> @enderror

        <label>Confirm New Password:</label><br>
        <input type="password" name="password_confirmation"><br>

        <button type="submit">Update Profile</button>
    </form>

    <hr>
    {{-- Role-specific dashboard info --}}
    @if(Auth::user()->role == 'admin')
        <h2>Admin Options</h2>
        <a href="{{ route('quizzes.create') }}">Create New Quiz</a><br>
        <a href="{{ route('quizzes.index') }}">Manage Quizzes</a><br>
        {{-- Add more admin-only links here --}}
    @else
        <h2>Student Options</h2>
        {{-- <a href="{{ route('quizzes.available') }}">Take a Quiz</a><br> --}}
        {{-- <a href="{{ route('scores.index') }}">View My Scores</a><br> --}}
        {{-- Add more student-only info here --}}
    @endif
</div>
@endsection
