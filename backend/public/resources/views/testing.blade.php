@extends ('layouts.main')
@section('title', 'Идет тестирование - '.$temp_testing->test->title)

@section('content')
    <div class="row">
        <div class="container content-area">
            <div class="row">
                <div class="col-4">
                    <h1> Вопрос {{ $current_quest_number }}/{{ count((array)$temp_testing->quest_arr) }} </h1>
                </div>
                <div class="col-8 text-right">
                    <h1> {{ $temp_testing->test->title }} </h1>
                </div>
            </div>
            @if(!empty($images))
                <div id="questImages" class="carousel fade" data-ride="false" data-wrap="true">
                    <div class="carousel-inner">
                        @foreach($images as $key=>$image)
                            <div class="carousel-item img-slide @if($key==0) active @endif">
                                <img class="d-block w-100" src="{{$image->path}}" alt="{{$image->path}}">
                            </div>
                        @endforeach
                    </div>
                    @if(count($images) > 1)
                        <a class="carousel-control-prev" href="#questImages" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#questImages" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
                </div>
            @endif
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-10 mt-3">
                        <h4> {{$temp_testing->quest->description}} </h4>
                    </div>
                </div>
                <form style="width: 100%">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-xs-12 mt-3">
                            <h5 class="text-muted">
                                @switch($temp_testing->quest->type)
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
                            @switch($temp_testing->quest->type)
                                @case("wch")
                                <textarea class="form-control" type="text" name="answer"></textarea>
                                @break
                                @case("mch")
                                <div class="funkyradio">
                                    @foreach($answers as $answer)
                                        <div class="funkyradio-success">
                                            <input type="checkbox" name="answer[]" id="answer-{{$answer['id']}}" value="{{$answer['id']}}"/>
                                            <label for="answer-{{$answer['id']}}">{{$answer['text']}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @break
                                @case("doc")
                                <textarea class="form-control" type="text" name="answer"></textarea>
                                @break
                                @default
                                <div class="funkyradio">
                                    @foreach($answers as $answer)
                                        <div class="funkyradio-success">
                                            <input type="radio" name="answer" id="answer-{{$answer['id']}}" value="{{$answer['id']}}"/>
                                            <label for="answer-{{$answer['id']}}">{{$answer['text']}}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endswitch
                        </div>
                        <div class="col-lg-4 col-xs-12 mt-3">
                            <h5 class="text-muted"> Файлы задания: </h5>
                            @if(!empty($temp_testing->quest->files))
                                <div class="list-group">
                                    @foreach($temp_testing->quest->files as $key=>$file)
                                        <a href="{{$file->path}}" title="{{$file->path}}"
                                           class="list-group-item list-group-item-action">{{$key+1}}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-2 col-md-3 col-xs-12">
                            <button type="submit" class="btn btn-purple">Отправить</button>
                        </div>
                        <div class="col-6">
                        </div>
                        <div class="col-lg-2 col-md-3 col-xs-12">
                            <a id="skip_button" href="#" class="btn btn-primary">Пропустить</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="content-area text-center time-card" id="time-left">
            <strong> Осталось: </strong>
            <p id="timeLeft" class="mb-0">Загрузка...</p>
            <input id="endtime" type="hidden" name="endtime" value="{{$temp_testing->endtime}}">
        </div>
    </div>
@endsection