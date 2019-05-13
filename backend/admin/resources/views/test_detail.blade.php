@extends ('layouts.main')
@section('title', 'Тест детально - '.$test->title)

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <!-- start content here -->
        <div class="wrap">
            <!-- edit test Modal -->
            <div id="updateTest" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Новый тест</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                        <form id="editTest">
                            <input type="hidden" name="id" value="{{$test->id}}">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control" placeholder="Название" value="{{$test->title}}">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Описание" name="description">{{$test->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <h6>Время</h6>
                                    <input type="time" name="time" class="form-control" min="0" value="{{$test->time}}">
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="category"> Категории </label>
                                    <select class="form-control" id="category" name="category[]" multiple>
                                        @foreach($allow_categories as $allow_category)
                                            @php $selected = false;
                                                foreach ($test->category as $category){
                                                    if($category->id===$allow_category->id)
                                                    {
                                                        $selected = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <option @if($selected) selected @endif value="{{$allow_category->id}}">{{$allow_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="type"> Тип </label>
                                    <select class="form-control" id="type" name="type">
                                        @foreach($types as $code=>$string)
                                            <option @if($code===$test->type) selected @endif value="{{$code}}">{{$string}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="alert alert-success mt-3" id="updateTestMessage" style="display: none">
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
            <section class="app-content" id="contact">
                <div class="card" id="test-info">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="m-b-lg">
                                        <a href="#" data-toggle="modal" data-target="#updateTest" data-animation="false"
                                           class="btn btn-primary btn-block text-white text-normalsize" id="modalUpdateTest">Редактировать тест</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="m-b-lg">
                                        <a href="#" data-toggle="modal" data-target="#questModal" data-animation="false"
                                           class="btn btn-primary btn-block text-normalsize">Изменить вопросы</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="m-b-lg">
                                        <a href="#" data-toggle="modal" data-target="#deleteTest" data-animation="false"
                                           class="btn btn-danger btn-block text-normalsize">Удалить тест</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .row -->
                        <div id="questList" class="row mt-5">

                        </div><!-- #contacts-list -->
                    @if(count($test["results"]))
                        <!-- start Active Leads -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="leads">
                                        <div class="card">
                                            <h1 class="head">Результаты</h1>
                                            <table class="table text-normalsize">
                                                <!-- start head -->
                                                <thead>
                                                <tr>
                                                    <th style="width: 2%">#</th>
                                                    <th style="width: 30%">Название теста</th>
                                                    <th style="width: 15%">Дата</th>
                                                    <th style="width: 15%">Время выполнения</th>
                                                    <th style="width: 40%">Результат</th>
                                                </tr>
                                                </thead>
                                                <!-- end head -->
                                                <!-- start body -->
                                                <tbody>
                                                <!-- start rows -->
                                                @foreach($test["results"] as $key=>$result)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$result->user->fullname}}</td>
                                                        <td>{{$result->date}}</td>
                                                        <td class="text-normalsize">{{$result->time}}</td>
                                                        <td>
                                                            <div class="progress">
                                                                @if($result->result < 25 )
                                                                    <div class="progress-bar progress-bar bg-danger"
                                                                         role="progressbar"
                                                                @elseif($result->result < 50)
                                                                    <div class="progress-bar progress-bar bg-warning"
                                                                         role="progressbar"
                                                                @elseif($result->result < 75)
                                                                    <div class="progress-bar progress-bar bg-primary"
                                                                         role="progressbar"
                                                                @else
                                                                    <div class="progress-bar progress-bar bg-success"
                                                                         role="progressbar"
                                                                         @endif
                                                                         aria-valuenow="{{$result->result}}" aria-valuemin="0"
                                                                         aria-valuemax="100"
                                                                         style="width: {{$result->result}}%">
                                                                        {{$result->result}} баллов
                                                                    </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <!-- end rows -->
                                                </tbody>
                                                <!-- end body -->
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end Active Leads -->
                        @endif
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- .app-content -->
        </div><!-- .wrap -->

        <!-- quests Modal -->
        <div id="questModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Новый вопрос</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                    </div>
                    <form id="editQuestInTestForm" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group m-0 mb-1">
                                <label for="category"> Выберите вопрос </label>
                                <input type="hidden" name="test-id" value="{{$test->id}}">
                                <select class="form-control" id="quests" name="quests[]" multiple>
                                    @php
                                        foreach ($allow_quests as $allow_quest)
                                        {
                                           echo "<option value='".$allow_quest["id"]."'";
                                           foreach ($test->questions->toArray() as $testQuestion)
                                           {
                                                if($allow_quest["id"] === $testQuestion["id"])
                                                {
                                                    echo "selected";
                                                    break;
                                                }
                                           }
                                           echo ">".$allow_quest["title"]."</option>";
                                        }
                                    @endphp
                                </select>
                            </div>
                            <div class="alert alert-success mt-3" id="updateQuestInTestMessage" style="display: none">
                                <strong> {{ session('message') }}</strong>
                            </div>
                        </div><!-- .modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div><!-- .modal-footer -->
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- delete item Modal -->
        <div id="deleteQuestInTest" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <input type="hidden" name="test_id" value="{{$test->id}}">
                    <input type="hidden" name="quest_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Удалить вопрос из теста?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Вы точно хотите удалить вопрос <strong></strong> ?</p>
                        <p>Вопрос будет удален из теста, но останется доступен для выбора</p>
                        <div class="alert alert-success mt-3" id="deleteQuestInTestMessage" style="display: none">
                            <strong> {{ session('message') }}</strong>
                        </div>
                    </div><!-- .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Удалить</button>
                    </div><!-- .modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- delete test Modal -->
        <div id="deleteTest" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <input type="hidden" name="test_id" value="{{$test->id}}">
                    <div class="modal-header">
                        <h4 class="modal-title">Удалить тест?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Вы точно хотите удалить вопрос <strong>{{$test->title}}</strong> ?</p>
                        <p>Будет удален сам тест, вопросы останутся доступными для выбора</p>
                    </div><!-- .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Удалить</button>
                    </div><!-- .modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- end the real content -->
@endsection