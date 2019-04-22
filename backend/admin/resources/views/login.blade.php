@extends ('layouts.main')
@section('title', 'Вход')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            <div class="row justify-content-center">
                <div class="col-md-4 col-xs-12">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Вход в панель администратора</h4>
                        </div>
                        <form id="loginForm" enctype="multipart/form-data" method="post" action="{{ route('login') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="login"> Логин </label>
                                    <input type="text" id="login" name="login" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password"> Пароль </label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                            </div><!-- .modal-body -->
                            <div class="modal-footer justify-content-around">
                                <button type="submit" class="btn btn-primary" data-dismiss="modal">Войти</button>
                            </div><!-- .modal-footer -->
                            @if ($errors->has('login'))
                                <div class="text-red text-center">
                                    <p>{{ $errors->first('login') }}</p>
                                </div>
                            @endif
                        </form>
                        <a href="{{ config("params.public_site_url")  }}" class="mt-1 mb-3 text-center" data-dismiss="modal">К основному сайту</a>
                    </div><!-- /.modal-content -->
                </div>
            </div>
        </div>
    </div>
    <!-- end the real content -->
@endsection