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
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- icon -->
    <link rel="icon" href="{{ asset('img/log.png') }}">
    <!-- end linking -->
    <title> TestAdmin - @yield('title') </title>
</head>
<body>
<!-- start admin -->
<section id="admin"
         @if(Route::current()->getName() === "login")
         class="w-100"
         @endif
>
    @if (Route::current()->getName() !== "login")
    <!-- start sidebar -->
    <div class="sidebar">
        <!-- start with head -->
        <div class="head">
            <a href="{{ route("index") }}" class="btn btn-danger">TestAdmin</a>
        </div>
        <!-- end with head -->
        <!-- start the list -->
        <div id="list">
            <ul class="nav flex-column">
                <li class="nav-item"><a href="{{ route("index") }}" class="nav-link @if(Route::current()->getName() === "index") active @endif"><i
                                class="fa fa-adjust"></i>Главная</a></li>
                <li class="nav-item"><a href="{{ route("usersList") }}" class="nav-link @if(Route::current()->getName() === "usersList"
                || Route::current()->getName() === "userProfile") active @endif"><i
                                class="fa fa-users"></i>Пользователи</a></li>
                {{--<li class="nav-item"><a href="#" class="nav-link" data-toggle="collapse"><i--}}
                                {{--class="fa fa-fire"></i>Тестирования</a></li>--}}
                <li class="nav-item"><a href="{{ route("testsList") }}" class="nav-link @if(Route::current()->getName() === "testsList") active @endif"><i class="fa fa-inbox"></i>Тесты</a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-edit"></i>Вопросы</a></li>
                <li class="nav-item">
                    <a href="#results" class="nav-link collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="fa fa-table"></i>Результаты
                        <span class="sub-ico">
                        <i class="fa fa-angle-down"></i>
                    </span>
                    </a>
                </li>
                <li class="sub collapse" id="results" aria-expanded="false" style="">
                    <a href="#" class="nav-link text-normalsize" data-parent="#results">По пользователям</a>
                    <a href="#" class="nav-link text-normalsize" data-parent="#results">По тестам</a>
                </li>
                <li class="nav-item"><a href="{{ route("settings") }}" class="nav-link @if(Route::current()->getName() === "settings") active @endif"><i
                                class="fa fa-cog"></i>Настройки</a></li>
                <li class="nav-item"><a href="support.html" class="nav-link"><i
                                class="fa fa-life-ring"></i>Поддержка</a></li>
            </ul>
        </div>
        <!-- end the list -->
    </div>
    <!-- end sidebar -->
    <!-- start content -->
    <div class="content">
        <!-- start content head -->
        <div class="head">
            <!-- head top -->
            <div class="top">
                <div class="left">
                    <button id="on" class="btn btn-info"><i class="fa fa-bars"></i></button>
                    <button id="off" class="btn btn-info hide"><i class="fa fa-align-left"></i></button>
                    <a href="{{ route("index") }}" class="btn btn-info hidden-xs-down"><i class="fa fa-home"></i>Домой</a>
                </div>
                <div class="right">
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" id="userDropdown" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">{{ Auth::user()->login }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route("userProfile",["login"=>Auth::user()->login]) }}">Профиль</a>
                            <a class="dropdown-item" href="{{ route("logout") }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end head top -->
            <!-- start head bottom -->
            <div class="bottom">
                <div class="left">
                    <h1>@yield('title')</h1>
                </div>
            </div>
            <!-- end head bottom -->
        </div>
        <!-- end content head -->
    @endif
        @if(Route::current()->getName() === "login")
            <div class="content ml-0">
        @endif
    @yield('content')
        @if(Route::current()->getName() === "login")
        </div>
        @endif
</section>
<!-- end admin -->
<!-- start screpting -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/tether.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/highcharts.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
<!-- end screpting -->
</body>
</html>
