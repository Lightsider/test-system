@extends ('layouts.main')
@section('title', 'Начать тест - '.$test->title)

@section('content')
    <div class="row">
        <div class="container content-area">
            <h1> Подтверждение </h1>
            <p>Вы собираетесь начать <strong>{{$test->title}}</strong></p>
            <strong>Описание:</strong>
            <p>{{$test->description}}</p>
            <strong>Ваш балл:</strong>
            <p>{{$user_result["value"]!==null?$user_result["value"]:"нет данных"}}</p>
            <strong>Тип:</strong>
            @if($test->type =="learn")
            <p>обучающий</p>
            @else
            <p>контрольный</p>
            @endif
            <strong>Категории:</strong>
            @if(!empty($test->category[0]))
                @foreach($test->category as $key => $category)
                    <p class="mb-0">
                        {{$category->name}};
                    </p>
                @endforeach
            @else
                <p>Без категории</p>
            @endif
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-12">
                    <a href="{{ route("startTest",["id"=>$test->id]) }}" class="btn btn-purple">Начать</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <p class="card-subtitle mb-2 text-center text-{{$average_value["color"]}}"><strong>Средний балл: {{$average_value["value"]??"нет данных"}}</strong></p>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <p class="card-subtitle mb-2 text-center"><strong>Время: {{$test->time}}</strong></p>
                </div>
                <div class="col-lg-4 col-sm-12 justify-content-center">
                    <p class="card-subtitle mb-2 text-center"><strong>Вопросов: {{count($test->questions)}}</strong></p>
                </div>
            </div>
        </div>
    </div>
@endsection