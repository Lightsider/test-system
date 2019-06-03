@extends ('layouts.main')
@section('title', 'Тесты')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            <div class="row">
                <div class="col-md-12">
                    <div class="mail-toolbar m-b-lg">
                        <div class="btn-group">
                            <a href="#" data-toggle="modal" data-target="#newTest"
                               class="btn btn-primary btn-block text-white">Новый</a>
                        </div>
                    </div>
                </div><!-- END column -->
            </div>
            <!-- new test Modal -->
            <div id="newTest" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Новый тест</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                        </div>
                        <form id="addTest">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control" placeholder="Название">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Описание" name="description"></textarea>
                                </div>
                                <div class="form-group">
                                    <h6>Активность</h6>
                                    <label class="radio-label" for="active" style="font-size: 15px">
                                        <input type="checkbox" id="active" name="active" value="1">
                                        Будет ли доступен этот тест для прохождения?
                                    </label>
                                </div>
                                <div class="form-group">
                                    <h6>Время</h6>
                                    <input type="time" name="time" class="form-control" min="0">
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="category"> Категории </label>
                                    <select class="form-control" id="category" name="category[]" multiple>
                                        @foreach($allow_categories as $allow_category)
                                            <option value="{{$allow_category->id}}">{{$allow_category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group m-0 mb-1">
                                    <label for="type"> Тип </label>
                                    <select class="form-control" id="type" name="type">
                                        @foreach($types as $code=>$string)
                                            <option value="{{$code}}">{{$string}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="alert alert-success mt-3" id="newTestMessage" style="display: none">
                                    <strong> {{ session('message') }}</strong>
                                </div>
                            </div><!-- .modal-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-success">Добавить</button>
                            </div><!-- .modal-footer -->
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <section class="app-content mt-5">
                <div class="m-b-lg nav-tabs-horizontal" >
                    <!-- start cards -->
                    <div class="tab-content p-md cards">
                        <div class="card card-top">
                            <h3 class="m-b-lg text-normalsize">Тесты</h3>
                            <div class="row" id="testsList">
                            </div><!-- .row -->
                        </div><!-- .tab-pane -->
                    </div><!-- .tab-content -->
                </div><!-- .nav-tabs-horizontal -->
            </section><!-- .app-content -->
        </div>
    </div>
    <!-- end the real content -->
@endsection