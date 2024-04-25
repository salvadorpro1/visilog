@if ($user && $user->role === 'administrador')
    <a href="{{ route('showRegister') }}">Registrar Registradores</a>
@endif
