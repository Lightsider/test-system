@extends ('layouts.main')
@section('title', 'Список тестов')

@section('content')
    <div class="row">
        <div class="container content-area">
            <h1> Доступные тесты </h1>
            <div class="row justify-content-around">
                @if(!empty($tests))
                    @foreach($tests as $test)
                        <div class="col-lg-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3" style="width: 100%">{{$test->title}}</h5>
                                    <h6 class="card-subtitle mb-2 text-{{$average_values[$test->id]["color"]}}">Средний балл: {{$average_values[$test->id]["value"]??"нет данных"}}</h6>
                                    <p class="card-subtitle mb-2 text-muted">Время: {{$test->time}}</p>
                                    <p class="card-subtitle mb-2 text-muted">Вопросов: {{count($test->questions)}}</p>
                                    @if($test->type =="learn")
                                        <p class="card-subtitle mb-2 text-muted">Тип: обучающий</p>
                                    @else
                                        <p class="card-subtitle mb-2 text-muted">Тип: контрольный</p>
                                    @endif

                                    <p class="card-text">{{$test->description}}</p>
                                    <p class="card-text mb-0"><strong>Категории:</strong></p>
                                    @if(!empty($test->category[0]))
                                        @foreach($test->category as $key => $category)
                                            <p class="card-text @if(count($test->category)-1 == $key)mb-3 @else mb-1 @endif">
                                                {{$category->name}};
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="card-text">Без категории</p>
                                    @endif
                                    @if(!empty($user_results[$test->id]["value"]))
                                    <p class="card-text text-{{$user_results[$test->id]["color"]}}"><strong>Ваш результат:</strong>
                                        {{$user_results[$test->id]["value"]}} </p>
                                    @else
                                        <p class="card-text"><strong>Вы не проходили этот тест</strong></p>
                                    @endif
                                    <a href="{{route("testPreview",["id"=>$test->id])}}" class="btn btn-purple">Начать</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p> Нет доступных тестов </p>
                @endif
            </div>
        </div>
    </div>
@endsection