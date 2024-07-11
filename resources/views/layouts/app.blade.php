<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('style')
    <style>
        .modalApp {
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-contentApp {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }
    </style>
</head>

<body>
    @include('includes._cintillo')
    @include('includes._register_button', ['titulo' => 'Consultar Cedula'])

    @yield('content')
    <div id="inactivityModal" class="modalApp" style="display: none;">
        <div class="modal-contentApp">
            <p>Se cerrará la sesión por inactividad. ¿Sigues ahí?</p>
            <p>Tiempo restante: <span id="timer">03:00</span></p>
        </div>
    </div>

    <script>
        let inactivityTime = function() {
            let time;
            let logoutTimer;
            let countdownTimer;
            const modal = document.getElementById("inactivityModal");
            const timerDisplay = document.getElementById("timer");

            // Duración del temporizador en segundos
            const modalTimeout = 30 * 60; // 30 minutos de inactividad para mostrar el modal
            const logoutTimeout = 3 * 60; // 3 minutos para cerrar sesión después de mostrar el modal

            // Inicializar temporizadores
            let inactivityDuration = modalTimeout;
            let remainingLogoutDuration = logoutTimeout;

            // Eventos para reiniciar el temporizador de inactividad
            const events = [
                'load', 'mousemove', 'mousedown', 'touchstart', 'click', 'keydown', 'scroll'
            ];

            // Asignar eventos para resetear el temporizador
            events.forEach(event => {
                window.addEventListener(event, resetTimer);
                modal.addEventListener(event, resetLogoutTimer);
            });

            function logout() {
                window.location.href = "{{ route('logout') }}";
            }

            function showModal() {
                modal.style.display = "block";
                remainingLogoutDuration = logoutTimeout; // Reiniciar duración de logout
                startCountdown(); // Iniciar el temporizador de cuenta regresiva
                logoutTimer = setTimeout(logout, logoutTimeout *
                    1000); // 3 minutos para cerrar sesión después de mostrar el modal
            }

            function resetLogoutTimer() {
                clearTimeout(logoutTimer);
                clearInterval(countdownTimer);
                startCountdown(); // Reiniciar el temporizador de cuenta regresiva
                logoutTimer = setTimeout(logout, remainingLogoutDuration *
                    1000); // Reiniciar el temporizador de cierre de sesión
            }

            function resetTimer() {
                clearTimeout(time);
                clearTimeout(logoutTimer);
                clearInterval(countdownTimer);
                modal.style.display = "none"; // Ocultar modal
                inactivityDuration = modalTimeout; // Reiniciar la duración de inactividad
                time = setTimeout(showModal, inactivityDuration * 1000); // Reiniciar el temporizador de inactividad
            }

            function startCountdown() {
                countdownTimer = setInterval(function() {
                    let minutes = parseInt(remainingLogoutDuration / 60, 10);
                    let seconds = parseInt(remainingLogoutDuration % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    timerDisplay.textContent = minutes + ":" + seconds;

                    if (--remainingLogoutDuration < 0) {
                        clearInterval(countdownTimer);
                        logout(); // Cerrar sesión cuando el temporizador llegue a 0
                    }
                }, 1000);
            }


            // Iniciar el temporizador de inactividad
            resetTimer();
        };

        inactivityTime();
    </script>

</body>

</html>
