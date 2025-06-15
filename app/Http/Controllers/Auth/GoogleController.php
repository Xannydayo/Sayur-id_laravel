<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Attempt to find user by google_id first
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // User found by google_id, log them in
                Auth::login($user);
            } else {
                // User not found by google_id, try finding by email
                $user = User::where('email', $googleUser->email)->first();

                if ($user) {
                    // User found by email, update their google_id and log them in
                    $user->google_id = $googleUser->id;
                    $user->save();
                    Auth::login($user);
                } else {
                    // No user found, create a new user
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make(Str::random(24)), // Generate a random password
                    ]);
                    Auth::login($user);
                }
            }

            return redirect()->intended('/');
        } catch (\Exception $e) {
            // Log the error for debugging purposes (optional, but recommended)
            // \Log::error('Google login error: ' . $e->getMessage());
            return redirect('auth/google')->withErrors(['google_login' => 'Could not log in with Google. Please try again.']);
        }
    }
} 