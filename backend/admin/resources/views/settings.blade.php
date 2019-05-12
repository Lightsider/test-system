@extends ('layouts.main')
@section('title', 'Настройки')

@section('content')
    <div id="real">
        <div class="wrap">
            <section class="app-content">
                <div class="card">
                    <h3 class="m-b-lg">Основные</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="{{ route('settings') }}">
                                {{csrf_field()}}
                                <div class="row mb-3">
                                    <div class="col-6">

                                        <div class="form-group">
                                            <label for="testing_time"> Время отображения тестирований на
                                                главной </label>
                                            <input type="text" id="testing_time" name="testing_time"
                                                   class="form-control"
                                                   value="@if(!empty($settings["testing_time"])){{$settings["testing_time"]}}@endif">
                                            <small> Введите его в формате "1 day; 2 week and etc."</small>
                                        </div>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <h6>Свободная регистрация</h6>
                                            <label class="radio-label" for="enable_register" style="font-size: 15px">
                                                <input type="checkbox" id="enable_register" name="enable_register"
                                                       value="yes"
                                                       @if($settings["enable_register"]==="yes") checked @endif>
                                                Разрешить пользователям регистрироваться самим
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Сохранить
                                        </button>
                                    </div>
                                </div>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger alert-dismissible mt-3">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        @foreach ($errors->all() as $error)
                                            <strong>{{ $error }}</strong>
                                        @endforeach
                                    </div>
                                @endif
                                @if (session('message'))
                                    <div class="alert alert-success alert-dismissible mt-3">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                        <strong> {{ session('message') }}</strong>
                                    </div>
                                @endif
                            </form>
                        </div><!-- END column -->
                    </div><!-- .row -->
                </div>

                <div class="card">
                    <h3 class="m-b-lg">Импорт</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="m-h-lg fz-md lh-lg">Здесь будут ваши настройки</p>
                        </div><!-- END column -->
                    </div><!-- .row -->
                </div>

                <div class="card">
                    <h3 class="m-b-lg">Экспорт</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="m-h-lg fz-md lh-lg">Здесь будут ваши настройки</p>
                        </div><!-- END column -->
                    </div><!-- .row -->
                </div>
            </section><!-- .app-content -->
        </div>
    </div>
@endsection