<?php

namespace App\Http\Controllers;

use App\Models\User;
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


    public function showRegister()
    {
        return view('register.registrarRegistrationForm');
    }

    public function saveRegistrar(Request $request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => 'registrador',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('show_ConsulForm')->with('success', 'Usuario creado satisfactoriamente.');
    }
}
