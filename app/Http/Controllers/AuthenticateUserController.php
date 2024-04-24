<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthenticateUserController extends Controller
{

    public function showLoginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('show_ConsulForm'));
        } else {
            return redirect()->back()->withInput()->withErrors(['username' => 'Credenciales inválidas']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
