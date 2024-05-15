<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .user-menu {
        display: flex;
        justify-content: space-between;
        background-color: #01313F;
        height: 60px;
        color: #FFFFFF
    }

    .user-menu__section {
        display: flex;
        justify-content: start;
        align-items: center;
        font-size: 24px;
        margin: 0 32px 0 8px;
        width: 50%
    }

    .user-menu__title {}

    .menu-usuario__section {
        display: flex;
        flex-grow: 1;
        width: 60%;

    }

    .user-menu__list {
        display: flex;
        width: 100%;
        justify-content: space-evenly;
        align-items: center;
    }

    .user-menu__item {
        list-style: none;
        cursor: pointer;
        font-family: Arial, sans-serif;

    }

    .user-menu__item-link {
        text-decoration: none;
        color: white;
        font-family: Arial, sans-serif;

    }

    .user-menu__item:hover {
        border-bottom: 4px solid #007bff;
        border-end-end-radius: 2px;
        border-end-start-radius: 2px;
        transition: 0.1s;
    }

    .user-menu__menu-container {}

    .user-menu__username {
        cursor: pointer;

    }

    .user-menu__username:hover {
        border-bottom: 4px solid #007bff;
        border-end-end-radius: 2px;
        border-end-start-radius: 2px;
        transition: 0.1s;
    }

    .user-menu__submenu {
        display: none;
        justify-content: center;
        align-items: center;
        top: 49px;
        position: absolute;
        background-color: #01313F;
        border-radius: 8px;
        padding: 12px;
        box-shadow: 0.5px 0.5px 8px 1px rgb(7, 1, 1);
    }

    .user-menu__submenu>.user-menu__item {
        margin: 4px 0
    }
</style>

<header>
    <div class="user-menu">
        <section class="user-menu__section">
            <h1 class="user-menu__title">{{ $titulo }}</h1>
        </section>
        <section class="menu-usuario__section">
            <ul class="user-menu__list">
                <li class="user-menu__item">
                    <a href="{{ route('show_Register_Visitor') }}" class="user-menu__item-link">Tabla de visitantes</a>
                </li>
                <li class="user-menu__item">
                    <a href="{{ route('show_Account') }}" class="user-menu__item-link">Reporte</a>
                </li>
                <li class="user-menu__item">
                    @if ($user && $user->role === 'administrador')
                        <a class="user-menu__item-link" href="{{ route('showRegisterCreate') }}">Crear operador</a>
                    @endif
                </li>
                <div class="user-menu__menu-container">
                    <div class="user-menu__username">
                        @if (Auth::check())
                            <a class="user-menu__item-link">{{ Auth::user()->username }}</a>
                        @endif
                    </div>
                    <ul class="user-menu__submenu">
                        <li class="user-menu__item">
                            <a href="{{ route('changePassword') }}" class="user-menu__item-link">Cambiar Contraseña</a>
                        </li>
                        <li class="user-menu__item">
                            <a href="{{ route('logout') }}" class="user-menu__item-link">Cerrar sesión</a>
                        </li>
                    </ul>
                </div>
            </ul>
        </section>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var username = document.querySelector('.user-menu__username');
        var submenu = document.querySelector('.user-menu__submenu');

        username.addEventListener('click', function(event) {
            event
                .stopPropagation();
            submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(event) {
            if (event.target !== username && !submenu.contains(event.target)) {
                submenu.style.display = 'none';
            }
        });
    });
</script>
