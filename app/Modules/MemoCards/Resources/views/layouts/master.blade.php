<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MemoCards</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
          crossorigin="anonymous">
    {{-- Laravel Mix - CSS File --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="body-{{ Route::currentRouteName() }}">
    <div class="content" id="app">
        @yield('content')
    </div>
    <div class="footer">@include('memocards::layouts.footer')</div>
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
