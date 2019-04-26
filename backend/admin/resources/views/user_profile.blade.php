@extends ('layouts.main')
@section('title', 'Пользователь - '.$user->login)

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            <div id="Profile">
                <input type="hidden" name="user-id" value="{{$user->id}}">
                <div class="profile-header card">
                    <div class="profile-cover">

                    </div><!-- .profile-cover -->

                    <!-- edit user Modal -->
                    <div id="editUser" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Редактировать пользователя</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                </div>
                                <form id="updateUser">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="user-id" class="form-control">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" name="login" class="form-control" placeholder="Логин">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control"
                                                   placeholder="Пароль">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                   placeholder="Повторите пароль">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="fullname" class="form-control" placeholder="ФИО">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="group" class="form-control" placeholder="Группа">
                                        </div>
                                        <div class="form-group">
                                            <h6>Статус</h6>
                                            <div>
                                                <label>
                                                    <input type="radio" name="status" value="user">
                                                    Студент
                                                </label>
                                            </div>
                                            <div>
                                                <label>
                                                    <input type="radio" name="status" value="admin">
                                                    Администратор
                                                </label>
                                            </div>
                                        </div>
                                        <div class="alert alert-success mt-3" id="updateUserMessage"
                                             style="display: none">
                                            <strong> {{ session('message') }}</strong>
                                        </div>
                                    </div><!-- .modal-body -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена
                                        </button>
                                        <button type="submit" class="btn btn-success">Сохранить</button>
                                    </div><!-- .modal-footer -->
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- deleteUser Modal -->
                    <div id="deleteUser" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <input type="hidden" name="user-id">
                                <div class="modal-header">
                                    <h4 class="modal-title">Удалить пользователя</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <p>Вы точно хотите удалить пользователя <strong></strong> ?</p>
                                    <div class="alert alert-success mt-3" id="deleteUserMessage" style="display: none">
                                        <strong> {{ session('message') }}</strong>
                                    </div>
                                </div><!-- .modal-body -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger">Удалить</button>
                                </div><!-- .modal-footer -->
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <div class="promo-footer">
                        <div class="row justify-content-center">
                            <div class="col-sm-2 col-sm-offset-3 col-xs-6 promo-tab">
                                <div class="text-center">
                                    <small>Прошел тестов</small>
                                    <h4 class="m-0 m-t-xs">{{ count($results) }}</h4>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-6 promo-tab">
                                <div class="text-center">
                                    <small>Средний балл</small>
                                    @if(!empty($averageValue))
                                        <h4 class="m-0 m-t-xs">{{ $averageValue }}</h4>
                                    @else
                                        <h4 class="m-0 m-t-xs"> Нет данных </h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!-- .promo-footer -->
                </div><!-- .profile-header -->
            </div>
        @if(count($results))
            <!-- start Active Leads -->
                <div class="row">
                    <div class="col-lg-12">
                        <div id="leads">
                            <div class="card">
                                <h1 class="head">Результаты</h1>
                                <table class="table text-normalsize">
                                    <!-- start head -->
                                    <thead>
                                    <tr>
                                        <th style="width: 2%">#</th>
                                        <th style="width: 30%">Название теста</th>
                                        <th style="width: 15%">Дата</th>
                                        <th style="width: 15%">Время выполнения</th>
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
                                            <td class="text-normalsize">{{$result->time}}</td>
                                            <td>
                                                <div class="progress">
                                                    @if($result->result < 25 )
                                                        <div class="progress-bar progress-bar bg-danger"
                                                             role="progressbar"
                                                    @elseif($result->result < 50)
                                                        <div class="progress-bar progress-bar bg-warning"
                                                             role="progressbar"
                                                    @elseif($result->result < 75)
                                                        <div class="progress-bar progress-bar bg-primary"
                                                             role="progressbar"
                                                    @else
                                                    <div class="progress-bar progress-bar bg-success"
                                                     role="progressbar"
                                                     @endif
                                                             aria-valuenow="{{$result->result}}" aria-valuemin="0"
                                                             aria-valuemax="100"
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
                    </div>
                </div>
                <!-- end Active Leads -->
            @endif
        </div>
    </div>
    <!-- end the real content -->
@endsection