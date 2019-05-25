@extends ('layouts.main')
@section('title', 'Результаты - '.$temp_testing->test->title)

@section('content')
    <div class="row">
        <div class="container content-area">
            <div class="row">
                <div class="col-4">
                    <h1> Результаты </h1>
                </div>
            </div>
            <div class="container">
                <h2> {{ $temp_testing->test->title }} </h2>
                <div class="row justify-content-center mb-5">
                    <div class="col-10 mt-3">
                        <h4> Ваш результат: </h4>
                        <h3 class="text-{{$result_color}}">{{$result->result}}</h3>
                        <p><strong>Затраченное время</strong> {{$result->time}}</p>
                    </div>
                </div>
            </div>
            @if($test->type=="learn")
                @foreach($test->questions as $key => $quest)
                    <div class="container">
                        <h2> Вопрос {{$key+1}} -
                            @if($temp_testing->quest_arr->{$quest->id}->score > 0)
                                <span class="text-green"> Верно </span>
                            @else
                                <span class="text-red"> Неверно </span>
                            @endif
                        </h2>
                        <div class="row justify-content-center">
                            <div class="col-10 mt-3">
                                <h4> {{$quest->description}} </h4>
                                <h5>
                                    Баллы: {{ $quest->score }}
                                </h5>
                            </div>
                        </div>
                        <div style="width: 100%">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-xs-12 mt-3">
                                    <h5 class="text-muted">
                                        @switch($quest->type)
                                            @case("wch")
                                            Развернутый ответ
                                            @break
                                            @case("mch")
                                            Несколько вариантов ответа
                                            @break
                                            @case("doc")
                                            Виртуальный контейнер
                                            @break
                                            @default
                                            Один вариант ответа
                                        @endswitch
                                    </h5>
                                </div>
                                <div class="col-lg-4 col-xs-12 mt-3">
                                    <h5 class="text-muted"> Файлы задания: </h5>
                                    @if(!empty($quest->files))
                                        <div class="list-group">
                                            @foreach($temp_testing->quest->files as $key=>$file)
                                                <a href="{{$file->path}}" title="{{$file->path}}"
                                                   class="list-group-item list-group-item-action">{{$key+1}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-1 col-xs-0"></div>
                            <div class="col-md-10 col-xs-12">
                                @if($temp_testing->quest_arr->{$quest->id}->score > 0)
                                    <div class="alert alert-success" role="alert" id="answerMessage">
                                @else
                                            <div class="alert alert-danger" role="alert" id="answerMessage">
                                @endif
                                                {{$quest->hint}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @endif
            <div class="content-area text-center time-card" id="time-left">
                <a class="btn btn-purple" style="margin: 0" href="{{route("index")}}">К тестам</a>
            </div>
        </div>
    </div>
@endsection