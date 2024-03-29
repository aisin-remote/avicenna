<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
    <div class="container-fluid"> 
        @yield('content')
    </div>
    </div>

    <!-- Scripts -->
@section('scripts')
    <!-- laravel mix -->
    <link href="{{ asset ('/css/aisya/pis.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
    <!-- laravel mix  -->
@show

</body>
</html>
