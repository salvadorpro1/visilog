<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('style')
</head>

<body>
    @include('includes._cintillo')
    @include('includes._register_button', ['titulo' => 'Consultar Cedula'])

    @yield('content')
</body>

</html>
