<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        $credentials['is_active'] = true;
        
        if (Auth::attempt($credentials)) {
            $log_data = [
                'log_type' => 'sign in',
                'description' => Auth::user()->username . ' signed in from ' . $request->ip(),
                'actor' => Auth::id(),
                'ip_address' => $request->ip()
            ];
            Log::create($log_data);
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        $log_data = [
            'log_type' => 'sign in',
            'description' => 'Failed sign in attempt from ' . $request->ip() . ' for username ' . $credentials['username'],
            'actor' => User::where('username', $credentials['username'])->value('id') ?? null,
            'ip_address' => $request->ip()
        ];
        Log::create($log_data);

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.'
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();
    
        return redirect()->route('login');
    }
}
