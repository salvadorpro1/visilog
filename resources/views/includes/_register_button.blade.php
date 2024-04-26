@if ($user && $user->role === 'administrador')
    <a href="{{ route('showRegisterCreate') }}"
        style="display: inline-block; padding: 10px 20px; margin-right: 10px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer; transition: background-color 0.3s ease;">Registrar
        Registradores</a>
@endif
