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
        </div>
    </div>

    <script>
        let inactivityTime = function() {
            let time;
            let logoutTimer;
            const modal = document.getElementById("inactivityModal");
            const stayLoggedInBtn = document.getElementById("stayLoggedInBtn");

            // Reset timer on mouse movement
            window.onload = resetTimer;
            window.onmousemove = resetTimer;
            window.onmousedown = resetTimer; // catches touchscreen presses
            window.ontouchstart = resetTimer; // catches touchscreen swipes
            window.onclick = resetTimer; // catches touchpad clicks
            window.onkeydown = resetTimer;
            window.addEventListener('scroll', resetTimer, true); // improved; see comments

            // Reset logout timer on modal interaction
            modal.onmousemove = resetLogoutTimer;
            modal.onmousedown = resetLogoutTimer; // catches touchscreen presses
            modal.ontouchstart = resetLogoutTimer; // catches touchscreen swipes
            modal.onclick = resetLogoutTimer; // catches touchpad clicks
            modal.onkeydown = resetLogoutTimer;
            modal.addEventListener('scroll', resetLogoutTimer, true); // improved; see comments

            function logout() {
                window.location.href = "{{ route('logout') }}";
            }

            function showModal() {
                modal.style.display = "block";
                logoutTimer = setTimeout(logout, 3 * 60 * 1000); // 3 minutes to logout after modal appears
            }

            function resetLogoutTimer() {
                clearTimeout(logoutTimer);
                logoutTimer = setTimeout(logout, 3 * 60 * 1000); // reset logout timer
            }

            function resetTimer() {
                clearTimeout(time);
                clearTimeout(logoutTimer);
                modal.style.display = "none"; // hide modal
                time = setTimeout(showModal, 30 * 60 * 1000);
            }

            stayLoggedInBtn.addEventListener("click", function() {
                modal.style.display = "none";
                resetTimer();
            });

            // Start timer
            resetTimer();
        };

        inactivityTime();
    </script>

</body>

</html>
