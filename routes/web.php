<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Livewire\Volt\Volt;
// UserController import is here if needed in the future
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== Landing Page =====
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ===== Default Dashboard (for auth users, already exists) =====
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ===== Settings (Volt/Livewire - use only if you have Volt) =====
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// ===== Profile Routes (ProfileController only) =====
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// If you ever want to switch to UserController for profiles:
// Route::middleware(['auth'])->group(function() {
//     Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
//     Route::post('/profile', [UserController::class, 'update'])->name('profile.update');
// });

// ===== Role Redirect After Login =====
Route::get('/redirect', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/player/dashboard');
    }
    return redirect('/'); // If not logged in
})->middleware('auth')->name('redirect');

// ===== Player Dashboard =====
Route::get('/player/dashboard', function () {
    return view('player.dashboard');
})->middleware('auth')->name('player.dashboard');

// ===== Admin Dashboard =====
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

// ===== Quiz Resourceful Routes (ALL CRUD) =====
// Add 'admin' middleware if you want only admins managing quizzes (optional in future)
Route::middleware(['auth'])->group(function () {
    Route::resource('quizzes', QuizController::class);
});

// ===== Laravel Auth Routes (leave as is) =====
require __DIR__.'/auth.php';


// Route to show edit question form
Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');

// Route to update question and options
Route::patch('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
