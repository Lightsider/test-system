@extends ('layouts.main')
@section('title', 'Вопросы')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <!-- start content here -->
        <div class="wrap">
            <section class="app-content" id="contact">
                <div class="row">
                    <div class="col-md-2">
                        <div class="app-action-panel" id="contacts-action-panel">
                            <div class="m-b-lg">
                                <a href="#" data-toggle="modal" data-target="#newQuestion"
                                   class="btn btn-primary btn-block text-normalsize">Новый вопрос</a>
                            </div>
                            <!-- contact category list -->
                            <div id="categories-list" class="app-actions-list scrollable-container">
                                <div class="list-group">
                                    <a href="#" class="list-group-item active">
                                        <input type="hidden" name="cat_id" value="all">
                                        <div class="item-data">
                                            <i class="fa fa-inbox text-color m-r-xs"></i>
                                            <span>Все категории</span>
                                        </div>
                                    </a>
                                </div><!-- .list-group -->

                                <hr class="m-0 m-b-md" style="border-color: #ddd;">

                                <div class="list-group">
                                    <div id="cat-list">
                                        @foreach($allow_categories as $allow_category)
                                            <a href="#" class="list-group-item">
                                                <input type="hidden" name="cat_id" value="{{$allow_category->id}}">
                                                <div class="item-data">
                                                    <span class="label-text">{{$allow_category->name}}</span>
                                                    <span class="pull-right hide-on-hover">{{count($allow_category->quests)}}</span>
                                                </div>
                                                <div class="item-actions">
                                                    <i class="item-action fa fa-edit" data-toggle="modal"
                                                       data-target="#editCategory"></i>
                                                    <i class="item-action fa fa-trash" data-toggle="modal"
                                                       data-target="#deleteCategory"></i>
                                                </div>
                                            </a><!-- .list-group-item -->
                                        @endforeach
                                    </div>
                                    <a href="#" class="list-group-item text-color" data-toggle="modal"
                                       data-target="#newCategory"><i class="fa fa-plus m-r-sm"></i> Новая категория </a>
                                </div>
                            </div><!-- #categories-list -->
                            <div class="m-h-md">
                            </div>
                        </div><!-- .app-action-panel -->
                    </div><!-- END column -->

                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mail-toolbar m-b-lg">
                                    <div class="btn-group" role="group">
                                    </div>
                                </div>
                            </div><!-- END column -->
                        </div><!-- .row -->

                        <div id="quests-list" class="row mt-5">

                        </div><!-- #contacts-list -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- .app-content -->
        </div><!-- .wrap -->


        <!-- new category Modal -->
        <div id="newCategory" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Новая категория</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="addCategory">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Название">
                            </div>
                            <div class="form-group">
                                <input type="text" name="slug" class="form-control" placeholder="Символьный код">
                            </div>
                            <div class="alert alert-success mt-3" id="addCategoryMessage" style="display: none">
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

        <!-- update category Modal -->
        <div id="editCategory" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Изменить категорию</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="updateCategory">
                        <div class="modal-body">
                            <input type="hidden" name="cat_id">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Название">
                            </div>
                            <div class="form-group">
                                <input type="text" name="slug" class="form-control" placeholder="Символьный код">
                            </div>
                            <div class="alert alert-success mt-3" id="updateCategoryMessage" style="display: none">
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
                        <input type="hidden" name="quest_id">
                        <p>Вы точно хотите удалить вопрос <strong></strong> ?</p>
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

        <!-- new question Modal -->
        <div id="newQuestion" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Новый вопрос</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                    </div>
                    <form id="addQuestion" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group m-0 mb-1">
                                <label for="title"> Название </label>
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
                            <div class="form-group m-0 mb-1" id="ch">
                                <label> Ответы </label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" name="ans-1-ch" class="form-control"
                                               placeholder="Ответ">
                                        <input type="text" name="ans-2-ch" class="form-control"
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
                            <div class="form-group m-0 mb-1" id="mch" style="display: none">
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
                            <div class="form-group m-0 mb-1" id="wch" style="display: none">
                                <label> Ответ </label>
                                <textarea type="text" id="ans-wch" name="ans-wch" class="form-control"
                                                  placeholder="Ответ"></textarea>
                            </div>
                            <div class="form-group m-0 mb-1" id="doc" style="display: none">
                                <div class="form-group m-0 mb-1">
                                    <label for="category"> Имя контейнера </label>
                                    <input type="text" id="docker-title" name="doc-name" class="form-control"
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

                            <div class="alert alert-success mt-3" id="newQuestMessage" style="display: none">
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


        <!-- edit question Modal -->
        <div id="editQuestion" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Изменить вопрос</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                    </div>
                    <form id="updateQuestion" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="id">
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
                                            <label class="radio-label" for="ans-2-ch" class="radio-label">
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
                                    <input type="text" id="docker-title" name="doc-name" class="form-control"
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


        <!-- delete category Modal -->
        <div id="deleteCategory" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Удалить категорию?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="cat_id">
                        <p>Вы точно хотите удалить категорию <strong></strong> ?</p>
                        <p>Все вопросы этой категории перейдут в категорию <br><strong>"без категории"</strong></p>
                        <div class="alert alert-success mt-3" id="deleteCategoryMessage" style="display: none">
                            <strong> {{ session('message') }}</strong>
                        </div>
                    </div><!-- .modal-body -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div><!-- .modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <!-- end the real content -->
@endsection