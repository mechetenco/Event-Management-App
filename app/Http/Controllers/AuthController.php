<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{


     public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:6|confirmed',
        ]);

        $response = Http::post('http://localhost:8000/api/register', [
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session([
                'api_token' => $data['token'],
                'user_id'   => $data['user']['id'],
                'user_name' => $data['user']['name'],
            ]);

            return redirect()->route('events.index')->with('success', 'Registration successful.');
        }

        return redirect()->back()->with('error', 'Registration failed.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $response = Http::post('http://localhost:8000/api/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
    $token = $response->json('token');

    // Call a "me" endpoint or decode user info if returned
    $userInfo = Http::withToken($token)->get('http://localhost:8000/api/user')->json();

    session([
        'api_token' => $token,
        'user_id' => $userInfo['id'], // Store user ID in session
    ]);
            return redirect()->route('events.index');
        }

        return back()->with('error', 'Invalid credentials.');
    }





    public function showForgotForm()
{
    return view('auth.forgot-password');
}

public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $response = Http::post('http://localhost:8000/api/forgot-password', [
        'email' => $request->email,
    ]);

    return $response->successful()
        ? back()->with('success', 'Reset link sent to your email.')
        : back()->with('error', 'Failed to send reset link.');
}

public function showResetForm(Request $request, $token)
{
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
        'token' => 'required',
    ]);

    $response = Http::post('http://localhost:8000/api/reset-password', [
        'email' => $request->email,
        'password' => $request->password,
        'password_confirmation' => $request->password_confirmation,
        'token' => $request->token,
    ]);

    return $response->successful()
        ? redirect()->route('login')->with('success', 'Password reset successfully.')
        : back()->with('error', 'Password reset failed.');
}

    public function logout()
    {
        $token = Session::get('api_token');

        if ($token) {
            Http::withToken($token)->post('http://localhost:8000/api/logout');
            Session::forget('api_token');
        }

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
