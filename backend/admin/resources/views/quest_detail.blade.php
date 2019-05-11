@extends ('layouts.main')
@section('title', 'Вопрос детально - '.$quest->title)

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <!-- start content here -->
        <div class="wrap">
            <!-- edit test Modal -->
            <!-- edit question Modal -->
            <div id="editQuestion" class="modal fade" tabindex="-1" role="dialog" data-animation="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Изменить вопрос</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>

                        </div>
                        <form id="updateQuestion" enctype="multipart/form-data" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="{{$quest->id}}">
                                <div class="form-group m-0 mb-1">
                                    <label for="category"> Название </label>
                                    <input type="text" name="title" class="form-control"
                                           placeholder="Название">
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="description"> Текст вопроса </label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="score"> Баллы </label>
                                    <input name="score" class="form-control" type="number" min="1" max="5" value="1">
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="description"> Текст подсказки для обучающего теста </label>
                                    <textarea name="hint" class="form-control"></textarea>
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="files"> Файлы </label><br>
                                    <input type="file" multiple name="files[]" id="files">
                                </div>
                                <div class="form-group m-0 mb-1" id="quest-files"></div>
                                <div class="form-group m-0 mb-1">
                                    <label for="category"> Категория </label>
                                    <select class="form-control" name="categories[]" multiple>
                                        @foreach($allow_categories as $allow_category)
                                            <option value="{{$allow_category->id}}">{{$allow_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="type"> Тип </label>
                                    <select class="form-control" name="type">
                                        @foreach($types as $code => $string)
                                            <option value="{{$code}}">{{$string}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-0 mb-1" id="uch">
                                    <label> Ответы </label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" id="ans-1-ch" name="ans-1-ch" class="form-control"
                                                   placeholder="Ответ">
                                            <input type="text" id="ans-2-ch" name="ans-2-ch" class="form-control"
                                                   placeholder="Ответ">
                                            <button class="btn btn-primary text-normalsize" name="add-ans-ch"
                                                    id="add-ans-ch"
                                                    value="Добавить ответ">Добавить ответ
                                            </button>
                                        </div>
                                        <div class="col-2">
                                            <div class="radio-label-div">
                                                <label class="radio-label" for="ans-1-ch">
                                                    <input type="radio" name="ans-right-ch" value="1">
                                                </label>
                                            </div>
                                            <div class="radio-label-div">
                                                <label for="ans-2-ch" class="radio-label">
                                                    <input type="radio" name="ans-right-ch" value="2">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-0 mb-1" id="umch" style="display: none">
                                    <label> Ответы </label>
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="text" id="ans-1-mch" name="ans-1-mch" class="form-control"
                                                   placeholder="Ответ">
                                            <input type="text" id="ans-2-mch" name="ans-2-mch" class="form-control"
                                                   placeholder="Ответ">
                                            <button class="btn btn-primary text-normalsize" name="add-ans-mch"
                                                    id="add-ans-mch"
                                                    value="Добавить ответ">Добавить ответ
                                            </button>
                                        </div>
                                        <div class="col-2">
                                            <div class="radio-label-div">
                                                <label class="radio-label" for="ans-1-mch">
                                                    <input type="checkbox" name="ans-right-mch-1" value="1">
                                                </label>
                                            </div>
                                            <div class="radio-label-div">
                                                <label class="radio-label" for="ans-2-mch">
                                                    <input type="checkbox" name="ans-right-mch-2" value="2">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-0 mb-1" id="uwch" style="display: none">
                                    <label> Ответ </label>
                                    <textarea type="text" id="ans-wch" name="ans-wch" class="form-control"
                                              placeholder="Ответ"></textarea>
                                </div>
                                <div class="form-group m-0 mb-1" id="udoc" style="display: none">
                                    <div class="form-group m-0 mb-1">
                                        <label for="category"> Имя контейнера </label>
                                        <input type="text" id="docker-title" name="docker-title" class="form-control"
                                               placeholder="Имя контейнера">
                                    </div>
                                    <label> Ответ </label>
                                    <div class="row">
                                        <div class="col-12">
                                        <textarea type="text" id="ans-doc" name="ans-doc" class="form-control"
                                                  placeholder="Ответ"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-success mt-3" id="updateQuestMessage" style="display: none">
                                    <strong> {{ session('message') }}</strong>
                                </div>
                            </div><!-- .modal-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
                                <button type="submit" class="btn btn-success">Сохранить</button>
                            </div><!-- .modal-footer -->
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <section class="app-content" id="contact">
                <div class="card" id="quest-info">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="m-b-lg">
                                        <a href="#" data-toggle="modal" data-target="#editQuestion" data-animation="false"
                                           class="btn btn-primary btn-block text-white text-normalsize" id="modalUpdateQuest">Редактировать вопрос</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="m-b-lg">
                                        <a href="#" data-toggle="modal" data-target="#deleteQuest" data-animation="false"
                                           class="btn btn-danger btn-block text-normalsize">Удалить вопрос</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .row -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- .app-content -->
        </div><!-- .wrap -->

        <!-- delete quest Modal -->
        <div id="deleteQuest" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Удалить вопрос</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="quest_id" value="{{$quest->id}}">
                        <p>Вы точно хотите удалить этот вопрос?</p>
                        <p>Вопрос будет удален <strong>безвозвратно</strong></p>
                        <div class="alert alert-success mt-3" id="deleteQuestMessage" style="display: none">
                            <strong> {{ session('message') }}</strong>
                        </div>
                    </div><!-- .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger">Удалить</button>
                    </div><!-- .modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- end the real content -->
@endsection