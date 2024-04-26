<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
        if (Auth::check() && Auth::user()->role === 'administrador') {
            return view('register.registrarRegistrationForm');
        } else {
            return redirect()->route('show_ConsulForm')->with('error', 'Acceso denegado. Solo los administradores pueden acceder.');
        }
    }

    public function saveRegistrar(Request $request)
    {
        // Define las reglas de validación
        $rules = [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'username' => 'required|alpha_num',
            'password' => 'required|min:6',
        ];

        // Define los mensajes de error personalizados
        $messages = [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'username.alpha_num' => 'El nombre de usuario solo puede contener letras y números.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        ];

        // Valida los datos
        $validator = Validator::make($request->all(), $rules, $messages);

        // Si la validación falla, redirige de vuelta con los errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si la validación es exitosa, crea el usuario
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => 'registrador',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('show_ConsulForm')->with('success', 'Usuario creado satisfactoriamente.');
    }
}
