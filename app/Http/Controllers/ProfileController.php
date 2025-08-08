<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Show edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Handle update profile request
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
