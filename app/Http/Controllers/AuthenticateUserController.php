<?php

namespace App\Http\Controllers;

use App\Models\Visitor; 
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
        // Solo tomamos los campos 'username' y 'password' del request
        $credentials = $request->only('username', 'password');
    
        // Intentamos autenticar al usuario con las credenciales proporcionadas
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Verificamos si el usuario está desactivado
            if ($user->estatus == 'desactivado') {
                // Si está desactivado, cerramos la sesión y redirigimos de vuelta con un error
                Auth::logout();
                return redirect()->back()->withInput()->withErrors(['username' => 'Este usuario está desactivado.']);
            }
    
            // Verificamos el rol del usuario y redirigimos a la ruta correspondiente
            if ($user->role == 'administrador') {
                return redirect()->intended(route('show_Dashboard'));
            } elseif ($user->role == 'operador') {
                return redirect()->intended(route('show_consult'));
            }
            } else {
            // Si las credenciales son incorrectas, redirigimos de vuelta con un error
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
        $operadores = User::where('role', 'operador')->where('estatus', 'activado')->get();

        if (Auth::check() && Auth::user()->role === 'administrador') {
            return view('register.registrarOperatorForm', compact('operadores'));
        } else {
            return redirect()->route('show_Dashboard')->with('error', 'Acceso denegado. Solo los administradores pueden acceder.');
        }
    }

    public function saveRegistrar(Request $request)
    {
        // Define las reglas de validación
        $rules = [
            'name' => 'required|regex:/^[\p{L}ñÑ\s]+$/u',
            'username' => 'required|alpha_num|unique:users,username', // Agregamos la regla 'unique'
            'password' => 'required|min:6|confirmed',
        ];
    
        // Define los mensajes de error personalizados
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            
            'username.required' => 'El campo nombre de usuario es obligatorio.',
            'username.alpha_num' => 'El nombre de usuario solo puede contener letras y números.',
            'username.unique' => 'El nombre de usuario ya está en uso.', // Mensaje personalizado
            
            'password.required' => 'El campo contraseña es obligatorio.',
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
            'password' => $request->password,
        ]);
    
        return redirect()->route('showRegisterCreate')->with('success', 'Usuario registrado satisfactoriamente.');
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
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 numeros o letras.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ];
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }
    
        // Validar el request con mensajes personalizados
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], $messages);
    
    
 
        $user->password = $request->new_password; // Asegúrate de hashear la nueva contraseña
        $user->save();
    
        Auth::logout();
        return redirect('/')->with('success', 'Contraseña cambiada exitosamente');
    }

    public function deactivateOperator($id)
    {
     $operador = User::findOrFail($id);
      if ($operador->role == 'operador') {
        $operador->estatus = 'desactivado';
        $operador->save();
      }

        return redirect()->route('showRegisterCreate')->with('success', 'Operador desactivado exitosamente.');
    }

    public function showHistory($operador_id)
    {
        // Obtener el operador
        $operador = User::findOrFail($operador_id);
    
        // Obtener el historial de visitantes registrados por este operador con paginación
        $historial = Visitor::where('user_id', $operador_id)->paginate(10);
    
        // Pasar los datos a la vista
        return view('register.historyOperator', compact('operador', 'historial'));
    }
}
