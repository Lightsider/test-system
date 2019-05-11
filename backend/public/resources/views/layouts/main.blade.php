<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- start linking  -->
    <link href="{{ asset('https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900') }}" rel="stylesheet">
    <link href="{{ asset('https://use.fontawesome.com/releases/v5.0.4/css/all.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- end linking -->
    <title> TestSystem - @yield('title') </title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light nav-user-side">
    <a class="navbar-brand" href="#">Test System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    @if(Auth::check())
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mr-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Тесты<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Профиль</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Контакты</a>
                </li>
            </ul>
        </div>
    @endif
</nav>
<div class="container container-main">
    @yield('content')
</div>
<!-- start screpting -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<!-- end screpting -->
</body>
</html>

