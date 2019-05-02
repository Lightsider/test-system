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
                                <a href="#" data-toggle="modal" data-target="#categoryModal"
                                   class="btn btn-primary btn-block text-normalsize">Новый вопрос</a>
                            </div>
                            <!-- contact category list -->
                            <div id="categories-list" class="app-actions-list scrollable-container">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
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

                        <div id="contacts-list" class="row">
                            <div class="col-sm-4">
                                <div class="card user-card contact-item p-md">
                                    <div class="media">
                                        <div class="media-body">
                                            <a href="#"><h5 class="media-heading title-color">Вопрос про ориентацию</h5>
                                            </a>
                                            <small class="media-meta">С выбором ответа</small>
                                        </div>
                                    </div>
                                    <div class="contact-item-actions">
                                        <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                                           data-target="#categoryModal"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                           data-target="#deleteCategoryModal"><i class="fa fa-trash"></i></a>
                                    </div><!-- .contact-item-actions -->
                                </div><!-- card user-card -->
                            </div><!-- END column -->

                            <div class="col-sm-4">
                                <div class="card user-card contact-item p-md">
                                    <div class="media">
                                        <div class="media-body">
                                            <a href="#"><h5 class="media-heading title-color">Вопрос про ориентацию</h5>
                                            </a>
                                            <small class="media-meta">С виртуальной машиной</small>
                                        </div>
                                    </div>
                                    <div class="contact-item-actions">
                                        <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                                           data-target="#categoryModal"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                           data-target="#deleteCategoryModal"><i class="fa fa-trash"></i></a>
                                    </div><!-- .contact-item-actions -->
                                </div><!-- card user-card -->
                            </div><!-- END column -->

                            <div class="col-sm-4">
                                <div class="card user-card contact-item p-md">
                                    <div class="media">
                                        <div class="media-body">
                                            <a href="#"><h5 class="media-heading title-color">Вопрос про ориентацию</h5>
                                            </a>
                                            <small class="media-meta">С виртуальной машиной</small>
                                        </div>
                                    </div>
                                    <div class="contact-item-actions">
                                        <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                                           data-target="#categoryModal"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                           data-target="#deleteCategoryModal"><i class="fa fa-trash"></i></a>
                                    </div><!-- .contact-item-actions -->
                                </div><!-- card user-card -->
                            </div><!-- END column -->

                            <div class="col-sm-4">
                                <div class="card user-card contact-item p-md">
                                    <div class="media">
                                        <div class="media-body">
                                            <a href="#"><h5 class="media-heading title-color">Вопрос про ориентацию</h5>
                                            </a>
                                            <small class="media-meta">Без выбора ответа</small>
                                        </div>
                                    </div>
                                    <div class="contact-item-actions">
                                        <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal"
                                           data-target="#categoryModal"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal"
                                           data-target="#deleteCategoryModal"><i class="fa fa-trash"></i></a>
                                    </div><!-- .contact-item-actions -->
                                </div><!-- card user-card -->
                            </div><!-- END column -->


                        </div><!-- #contacts-list -->
                    </div><!-- END column -->
                </div><!-- .row -->
            </section><!-- .app-content -->
        </div><!-- .wrap -->


        <!-- new contact Modal -->
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

        <!-- update contact Modal -->
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

        <!-- delete item Modal -->
        <div id="deleteItemModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Удалить категорию</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Вы точно хотите удалить категорию <strong>Kenobi</strong> ?</p>
                        <p>Все вопросы этой категории перейдут в категорию <br><strong>"без категории"</strong></p>
                    </div><!-- .modal-body -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Удалить</button>
                    </div><!-- .modal-footer -->
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- new category Modal -->
        <div id="categoryModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Новый вопрос</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>

                    </div>
                    <form id="newCategoryForm" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group m-0 mb-1">
                                <label for="category"> Название </label>
                                <input type="text" id="question-title" name="question-title" class="form-control"
                                       placeholder="Название">
                            </div>
                            <div class="form-group m-0 mb-1">
                                <label for="category"> Текст вопроса </label>
                                <textarea id="question-quest" name="question-quest" class="form-control"></textarea>
                            </div>
                            <div class="form-group m-0 mb-1">
                                <label for="quest-files"> Файлы </label><br>
                                <input type="file" multiple name="quest-files" id="quest-files">
                            </div>
                            <div class="form-group m-0 mb-1">
                                <p><a href="#" download="true">Файл 1</a> <a href="#" class="text-danger"> Удалить </a>
                                </p>
                                <p><a href="#" download="true">Файл 2</a> <a href="#" class="text-danger"> Удалить </a>
                                </p>
                                <p><a href="#" download="true">Файл 3</a> <a href="#" class="text-danger"> Удалить </a>
                                </p>
                            </div>
                            <div class="form-group m-0 mb-1">
                                <label for="category"> Категория </label>
                                <select class="form-control" id="category" name="category">
                                    <option>HTML</option>
                                    <option>CSS</option>
                                    <option>Javascript</option>
                                    <option>Bootstrap</option>
                                    <option>AngularJs</option>
                                </select>
                            </div>
                            <div class="form-group m-0 mb-1">
                                <label for="question-type"> Тип </label>
                                <select class="form-control" id="question-type" name="question-type">
                                    <option value="choose">С выбором ответа</option>
                                    <option value="multi_choose">С множественным выбором</option>
                                    <option value="wo_choose">Без выбора ответа</option>
                                    <option value="docker">С виртуальной машиной</option>
                                </select>
                            </div>
                            <div class="form-group m-0 mb-1" id="choose">
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
                            <div class="form-group m-0 mb-1" id="multi_choose" style="display: none">
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
                                            <label class="radio-label" for="ans-2-mch" class="radio-label">
                                                <input type="checkbox" name="ans-right-mch-2" value="2">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-0 mb-1" id="wo_choose" style="display: none">
                                <label> Ответ </label>
                                <div class="row">
                                    <div class="col-10">
                                        <input type="text" id="ans-1-woch" name="ans-1-woch" class="form-control"
                                               placeholder="Ответ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-0 mb-1" id="docker" style="display: none">
                                <div class="form-group m-0 mb-1">
                                    <label for="category"> Имя контейнера </label>
                                    <input type="text" id="docker-title" name="docker-title" class="form-control"
                                           placeholder="Имя контейнера">
                                </div>
                                <label> Ответы </label>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" id="ans-1-doc" name="ans-1-doc" class="form-control"
                                               placeholder="Ответ">
                                        <input type="text" id="ans-2-doc" name="ans-2-doc" class="form-control"
                                               placeholder="Ответ">
                                        <button class="btn btn-primary text-normalsize" name="add-ans-doc"
                                                id="add-ans-doc"
                                                value="Добавить ответ">Добавить ответ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal">Сохранить</button>
                        </div><!-- .modal-footer -->
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <!-- delete item Modal -->
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