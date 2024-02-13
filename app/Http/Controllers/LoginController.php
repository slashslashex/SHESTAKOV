<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
public function showLoginForm()
{
    return view('signin');
}

    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            // Аутентификация успешна
            $user = Auth::user();
            return redirect()->intended(route('home'));
        } else {
            // Неверные учетные данные
            return back()->withErrors([
                'x' => 'x',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

//        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
