@extends ('layouts.main')
@section('title', 'Пользователи')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            <section class="app-content" id="contact">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="btn-group">
                                        <a href="#" data-toggle="modal" data-target="#newUser" class="btn btn-primary btn-block text-white">Новый</a>
                                    </div>
                                </div>
                            </div><!-- END column -->
                        </div><!-- .row -->

                        <!-- new user Modal -->
                        <div id="newUser" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Новый пользователь</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form action="{{ route('addOrUpdateUser') }}" id="addUser">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" name="login" class="form-control" placeholder="Логин">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control" placeholder="Пароль">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль">
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
                                                        <input type="radio" id="radioStud" name="status" value="user">
                                                        Студент
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <input type="radio" id="radioAdmin" name="status" value="admin">
                                                        Администратор
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="alert alert-success mt-3" id="newUserMessage" style="display: none">
                                                <strong> {{ session('message') }}</strong>
                                            </div>
                                        </div><!-- .modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
                                            <button type="submit" class="btn btn-success">Добавить</button>
                                        </div><!-- .modal-footer -->
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- delete item Modal -->
                        <div id="deleteItemModal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Удалить пользователя</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Вы точно хотите удалить пользователя <strong>Kenobi</strong> ?</p>
                                    </div><!-- .modal-body -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Удалить</button>
                                    </div><!-- .modal-footer -->
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div id="contacts-list" class="row">
                            @foreach($users as $user)
                                <div class="col-sm-6">
                                    <div class="card user-card contact-item p-md">
                                        <div class="media">
                                            <div class="media-left">
                                                <div class="avatar avatar-xl avatar-circle">
                                                    @if($user->usersStatus->value === "admin")
                                                        <a href="#"><img src="/img/admin.png" alt="admin image">
                                                    @else
                                                                <a href="#"><img src="/img/stud.png" alt="user image">
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="#"><h5 class="media-heading title-color">{{ $user->fullname }}</h5></a>
                                                <small class="media-meta">{{ $user->usersStatus->value }}</small>
                                            </div>
                                        </div>
                                        <div class="contact-item-actions">
                                            <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#contactModal"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#deleteItemModal"><i class="fa fa-trash"></i></a>
                                        </div><!-- .contact-item-actions -->
                                    </div><!-- card user-card -->
                                </div><!-- END column -->
                            @endforeach
                        </div><!-- #contacts-list -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- .app-content -->
        </div>
    </div>
    <!-- end the real content -->
@endsection