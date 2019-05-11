@extends ('layouts.main')
@section('title', 'Вход')

@section('content')
    <div class="row h-100 justify-content-center align-items-center" style="margin-top: 10%;">
        <div class="col-md-offset-3 col-md-6">
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab"
                                                              data-toggle="tab">Вход</a></li>
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Регистрация</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane fade in active show" id="Section1">
                        <form class="form-horizontal" method="post" action="{{ route("login") }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="auth-login">Логин</label>
                                <input type="text" class="form-control" id="auth-login" name="login">
                            </div>
                            <div class="form-group">
                                <label for="auth-password">Пароль</label>
                                <input type="password" class="form-control" id="auth-password" name="password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Войти</button>
                            </div>
                            @if ($errors->has('login'))
                                <div class="text-red text-center">
                                    <p>{{ $errors->first('login') }}</p>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                        <form class="form-horizontal" action="{{route("register")}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="reg-fullname">ФИО</label>
                                <input type="text" class="form-control" id="reg-fullname" name="fullname">
                            </div>
                            <div class="form-group">
                                <label for="reg-login">Логин</label>
                                <input type="text" class="form-control" id="reg-login" name="login">
                            </div>
                            <div class="form-group">
                                <label for="reg-group">Группа</label>
                                <input type="text" class="form-control" id="reg-group" name="group">
                            </div>
                            <div class="form-group">
                                <label for="reg-pass">Пароль</label>
                                <input type="password" class="form-control" id="reg-pass" name="password">
                            </div>
                            <div class="form-group">
                                <label for="reg-passrepeat">Повторить пароль</label>
                                <input type="password" class="form-control" id="reg-passrepeat" name="password_confirmation">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Зарегистрироваться</button>
                            </div>
                            @if ($errors->has('register'))
                                <div class="text-red text-center">
                                    <p>{{ $errors->first('register') }}</p>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.col-md-offset-3 col-md-6 -->
    </div><!-- /.row -->
@endsection