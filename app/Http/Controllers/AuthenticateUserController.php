<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
            return view('register.registrarOperatorForm');
        } else {
            return redirect()->route('show_ConsulForm')->with('error', 'Acceso denegado. Solo los administradores pueden acceder.');
        }
    }

    public function saveRegistrar(Request $request)
    {
        // Define las reglas de validación
        $rules = [
            'name' => 'required|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/',
            'username' => 'required|alpha_num',
            'password' => 'required|min:6|confirmed', // Agregamos la regla 'confirmed' para validar la confirmación de la contraseña
        ];

        // Define los mensajes de error personalizados
        $messages = [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'username.alpha_num' => 'El nombre de usuario solo puede contener letras y números.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
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
            'role' => 'operador',
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('show_ConsulForm')->with('success', 'Usuario creado satisfactoriamente.');
    }

    public function showChangePassword()
    {
        return view('changePassword.index');
    }

    public function changePassword(Request $request)
    {
        // Personalizar los mensajes de validación
        $messages = [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'new_password.required' => 'La nueva contraseña es obligatoria.',
            'new_password.string' => 'La nueva contraseña debe ser una cadena de texto.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ];
    
        // Validar el request con mensajes personalizados
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], $messages);
    
        $user = Auth::user();
    
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }
    
        $user->password = Hash::make($request->new_password); // Asegúrate de hashear la nueva contraseña
        $user->save();
    
        return redirect()->route('show_ConsulForm')->with('success', 'Contraseña cambiada exitosamente');
    }

}
