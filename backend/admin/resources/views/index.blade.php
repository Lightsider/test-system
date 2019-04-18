@extends ('layouts.main')
@section('title', 'Главная')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            <div class="row">
                <div class="col-lg-6">
                    <!-- avtive -->
                    <div class="activeMode">
                        <div class="card">
                            <h1 class="text-normalsize">Остановить все тестирования?</h1>
                            <a href="" class="btn btn-danger">Остановить</a>
                        </div>
                    </div>
                    <!-- end active -->
                </div>
            </div>
            <section class="app-content">
                <div class="m-b-lg nav-tabs-horizontal">
                    <!-- start cards -->
                    <div class="tab-content p-md cards">
                        <div class="card card-top">
                            <h3 class="m-b-lg text-normalsize">Недавние тестирования</h3>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <a href="#">
                                        <div class="card card-default">
                                            <div class="card-header">
                                                <h4 class="card-title text-normalsize">Тестирование на
                                                    ориентацию</h4>
                                            </div>
                                            <div class="card-block">
                                                <p><strong>Решают:</strong> 15</p>
                                                <p><strong>Закончили:</strong> 5</p>
                                                <p><strong>Всего:</strong> 20</p>
                                            </div>
                                            <div class="card-footer">
                                                <p><strong>Времени осталось:</strong> 12:50</p>
                                            </div>
                                        </div>
                                    </a>
                                </div><!-- END column -->
                                <div class="col-sm-6 col-md-4">
                                    <a href="#">
                                        <div class="card card-info">
                                            <div class="card-header">
                                                <h4 class="card-title text-normalsize">Тестирование на
                                                    ориентацию</h4>
                                            </div>
                                            <div class="card-block card-text">
                                                <p><strong>Решают:</strong> 0</p>
                                                <p><strong>Закончили:</strong> 20</p>
                                                <p><strong>Всего:</strong> 20</p>
                                            </div>
                                            <div class="card-footer card-header">
                                                <p><strong>Завершено:</strong> 12:50 назад</p>
                                            </div>
                                        </div>
                                    </a>
                                </div><!-- END column -->
                            </div><!-- .row -->
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .nav-tabs-horizontal -->
            </section><!-- .app-content -->
            <!-- start analytics -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="analytics">
                        <div class="card">
                            <div class="icon"><i class="fa fa-inbox"></i></div>
                            <div class="text">
                                <h1>984</h1>
                                <p>Всего тестов</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="analytics">
                        <div class="card">
                            <div class="icon"><i class="fa fa-edit"></i></div>
                            <div class="text">
                                <h1>1455</h1>
                                <p>Всего вопросов</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="analytics">
                        <div class="card">
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <div class="text">
                                <h1>32</h1>
                                <p>Всего пользователей</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end analytics -->
        </div>
    </div>
    <!-- end the real content -->
@endsection