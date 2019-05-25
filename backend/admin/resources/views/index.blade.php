@extends ('layouts.main')
@section('title', 'Главная')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            @if($current_testing)
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
            @endif

                <section class="app-content">
                    <div class="m-b-lg nav-tabs-horizontal">
                        <!-- start cards -->
                        <div class="tab-content p-md cards">
                            <div class="card card-top">
                                @if($current_testing)
                                    <h3 class="m-b-lg text-normalsize">Недавние тестирования</h3>
                                    <div class="row">
                                        @foreach($current_testing as $test)
                                            {{-- TODO вывести информацию --}}
                                        <div class="col-sm-6 col-md-4">
                                            <div class="card card-default">
                                                <div class="card-header">
                                                    <h4 class="card-title text-normalsize">{{ $test->test->title }} </h4>
                                                </div>
                                                <div class="card-block">
                                                    <p><strong>Решают:</strong> TODO</p>
                                                    <p><strong>Закончили:</strong> TODO</p>
                                                    <p><strong>Всего:</strong> TODO</p>
                                                </div>
                                                <div class="card-footer">
                                                    <p><strong>Времени осталось:</strong> TO DO</p>
                                                </div>
                                            </div>
                                        </div><!-- END column -->
                                        @endforeach
                                    </div><!-- .row -->
                                @else
                                    <h3 class="m-b-lg text-normalsize">Нет свежих тестирований</h3>
                            </div><!-- .tab-pane -->
                        </div><!-- .tab-content -->
                    </div><!-- .nav-tabs-horizontal -->
                </section><!-- .app-content -->
            @endif
            <!-- start analytics -->
            <div class="row">
                <div class="col-lg-3">
                    <div class="analytics">
                        <div class="card">
                            <div class="icon"><i class="fa fa-inbox"></i></div>
                            <div class="text">
                                <h1>{{ $tests_count }}</h1>
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
                                <h1>{{ $quests_count }}</h1>
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
                                <h1>{{ $users_count }}</h1>
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