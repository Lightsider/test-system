@extends ('layouts.main')
@section('title', 'Профиль - '. $user->fullname)

@section('content')
    <div class="row">
        <div class="container content-area">
            <h1> Профиль </h1>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" method="post" action="{{ route("profile") }}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-12 col-lg-4">
                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" class="form-control disabled" readonly id="login"
                                           value="{{$user->login}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-4">
                                <div class="form-group">
                                    <label for="fullname">ФИО</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname"
                                           value="{{$user->fullname}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-4">
                                <div class="form-group">
                                    <label for="group">Группа</label>
                                    <input type="text" class="form-control" name="group" id="group"
                                           value="{{$user->group}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group">
                                    <label for="auth-password">Новый пароль</label>
                                    <input type="password" class="form-control" id="auth-password" name="password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group">
                                    <label for="auth-password-confirm">Повторите пароль</label>
                                    <input type="password" class="form-control" id="auth-password-confirm" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Сохранить</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row justify-content-center">
                        <div class="col-xs-12 col-lg-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger"  style="margin: 0" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Выйти</button>
                            </div>
                        </div>
                    </div>
                    @if (session('message'))
                        <div class="text-success text-center">
                            <strong> {{ session('message') }}</strong>
                        </div>
                    @endif
                    @if ($errors->has('password'))
                        <div class="text-red text-center">
                            <p>{{ $errors->first('password') }}</p>
                        </div>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div><!-- END column -->
            </div><!-- .row -->
        </div>

        <div class="container content-area">
            <h1> Результаты </h1>
            <div class="row">
                <div class="col-md-4">
                    <h3> Всего: </h3>
                    <p><strong>Тестов прошел:</strong> {{ count($results) }} </p>
                    <p><strong>Средний балл:</strong> {{ $average_value["value"]??"нет данных" }} </p>
                </div><!-- END column -->
                <div class="col-md-4">
                    <h3> Последний: </h3>
                    @if($last_result!==null)
                        <p><strong><i>{{ $last_result->test->title }}</i></strong></p>
                        <p><strong>Результат:</strong> {{ $last_result->result }} </p>
                    @else
                        <p><strong><i>нет данных</i></strong></p>
                    @endif
                </div><!-- END column -->
                <div class="col-md-4">
                    <h3> Лучший: </h3>
                    @if($max_result!==null)
                        <p><strong><i>{{ $max_result->test->title }}</i></strong></p>
                        <p><strong>Результат:</strong> {{ $max_result->result }} </p>
                    @else
                        <p><strong><i>нет данных</i></strong></p>
                    @endif
                </div><!-- END column -->
            </div><!-- .row -->
            @if(count($results)>0)
                <div class="row">
                    <div class="col-12">
                        <h2> Все результаты: </h2>
                        <table class="table">
                            <!-- start head -->
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="width: 30%">Название теста</th>
                                <th style="width: 15%">Дата</th>
                                <th style="width: 15%">Время</th>
                                <th style="width: 40%">Результат</th>
                            </tr>
                            </thead>
                            <!-- end head -->
                            <!-- start body -->
                            <tbody>
                            <!-- start rows -->
                            @foreach($results as $key=>$result)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$result->test->title}}</td>
                                    <td>{{$result->date}}</td>
                                    <td>{{$result->time}}</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar bg-{{$result->color}}" role="progressbar"
                                                 aria-valuenow="{{$result->result}}" aria-valuemin="0" aria-valuemax="100"
                                                 style="width: {{$result->result}}%">
                                                {{$result->result}} баллов
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- end rows -->
                            </tbody>
                            <!-- end body -->
                        </table>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection