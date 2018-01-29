<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>MoneyGuru-0.1</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body>

        <div id="app">

            <guru-nav-bar></guru-nav-bar>

            <router-view></router-view>

        </div>

        <script src="{{ asset('js/app.js') }}"></script>

    </body>

</html>
