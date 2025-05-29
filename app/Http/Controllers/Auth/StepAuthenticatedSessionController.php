<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class StepAuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Call STEP API for authentication
        $response = Http::post('https://udd.steps.com.ph/api/other/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Handle authentication failure
        if ($response->failed()) {
            return back()->withErrors(['email' => 'Invalid STEP credentials.']);
        }

        $stepData = $response->json();

        // Check if user exists or create a new user locally
        $user = User::updateOrCreate(
            ['email' => $stepData['user']['email']],
            [
                'name' => $stepData['user']['full_name'],
                'password' => $stepData['user']['email'],
                'step_token' => $stepData['token'], // Random password
            ]
        );

        // Login user locally via Laravel Breeze
        Auth::login($user);

        // Redirect to intended route (typically dashboard)
        return redirect()->intended(route('dashboard'));
    }
}
