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
                                    <form action="{{ route('addUser') }}" id="addUser">
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

                        <!-- edit user Modal -->
                        <div id="editUser" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Редактировать пользователя</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form id="updateUser">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user-id" class="form-control">
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
                                            <div class="alert alert-success mt-3" id="updateUserMessage" style="display: none">
                                                <strong> {{ session('message') }}</strong>
                                            </div>
                                        </div><!-- .modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
                                            <button type="submit" class="btn btn-success">Сохранить</button>
                                        </div><!-- .modal-footer -->
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <!-- delete item Modal -->
                        <div id="deleteUser" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <input type="hidden" name="user-id">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Удалить пользователя</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

                        <div id="contacts-list" class="row">
                        </div><!-- #contacts-list -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- .app-content -->
        </div>
    </div>
    <!-- end the real content -->
@endsection