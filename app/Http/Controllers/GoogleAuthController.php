<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();

            // Check if a user exists with the same Google ID
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // Check if the email already exists in the database
                $user = User::where('email', $google_user->getEmail())->first();

                if ($user) {
                    // Update the existing user with the Google ID
                    $user->update([
                        'google_id' => $google_user->getId(),
                    ]);
                } else {
                    // Create a new user if the email does not exist
                    $user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'google_id' => $google_user->getId(),
                    ]);
                }
            }


        // Store Google user data in session
        session([
            'user' => [
                'google_id' => $google_user->getId(),
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'avatar' => $google_user->getAvatar(),
            ]
        ]);

            // Log the user in
            Auth::login($user);
            return redirect()->intended('dashboard');
        } catch (\Throwable $th) {
            // Handle errors
            return redirect('/login')->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }

    public function dashboard()
{
    // Pass the user data from the session to the Inertia page
    return inertia('Dashboard', [
        'user' => session('user'),
    ]);
}

}
