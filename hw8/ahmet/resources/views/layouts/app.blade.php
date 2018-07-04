<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet" media="screen">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script type="text/javascript" src="{!! asset('js/profile.js') !!}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('inc.navbar')
        <div class="mx-auto" style=" max-width: 850px; margin: auto;" id="app">
            @yield('content')
        </div>
    @yield('profile')

    @include('inc.footer')
</body>
</html>
