@extends ('layouts.main')
@section('title', 'Настройки')

@section('content')
    <!-- start with the real content -->
    <div id="real">
        <div class="wrap">
            <section class="app-content">
                <div class="card">
                    <h3 class="m-b-lg">Кидать тапками</h3>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <p>Задавать вопросы, а так же сообщать о багах или предложениях по следующим адресам</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5> На почту </h5>
                            <p class="m-h-lg fz-md lh-lg"><strong>Mail:</strong> <a href="mail:andrew9727@mail.ru">
                                    andrew9727@mail.ru </a></p>
                        </div><!-- END column -->
                    </div><!-- .row -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5> Если сильно хочется </h5>
                            <p class="m-h-lg fz-md lh-lg"><strong>Telegram:</strong> <a
                                        href="https://t.me/Ob1Wan_Kenob1"> @Ob1Wan_Kenob1 </a></p>
                        </div><!-- END column -->
                    </div><!-- .row -->
                </div>
                <div class="card">
                    <div class="row mt-3 justify-content-center">
                        <div class="col-md-12 text-center mb-3">
                            <h3>Надеюсь, вам понравится пользоваться этой системой. И да пребудет с вами Сила!</h3>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <img src="img/obi.jpg" style="width:100%;">
                        </div>
                    </div>
                </div>
            </section><!-- .app-content -->
        </div>
    </div>
    <!-- end the real content -->
@endsection