<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MemoCards</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    {{-- Laravel Mix - CSS File --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="body-{{ Route::currentRouteName() }}">
    <div class="full-height flex flex-col justify-between w-full" id="app">
        <header class="text-center">
            <h1>MemoCards</h1>
        </header>
        <div class="content content flex-auto relative">
            @yield('content')
        </div>
        <footer class="footer text-center">
            @include('memocards::layouts.footer')
        </footer>
    </div>

</body>
<script>
    window.Laravel = @json([
            'baseUrl' => url('/'),
            'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) {
                return [$route->getName() => $route->uri()];
            }),
            'user' => auth()->user()
        ]);

    window.Laravel.curentRoute = "{{ Route::currentRouteName() }}";
</script>
{{-- Laravel Mix - JS File --}}
<script src="{{ mix('js/app.js') }}"></script>
</html>
