<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>consultar cedula</title>
</head>

<body>
    @include('includes._register_button')
    <a href="{{ route('logout') }}">logout</a>
    <h1>consultar cedula</h1>
    <form method="POST" action="">
        @csrf
        <label for="cedula">Cedula</label>
        <input type="number" name="cedula" id="cedula">
        <input type="submit" value="consultar">
    </form>

    @if (session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <script>
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
        }, 5000);
    </script>


</body>

</html>
