@extends ('layouts.main')
@section('title', 'Результаты')

@section('content')
    <div id="real">
        <div class="wrap">
            <section class="app-content">
                @if(!empty($results))
                <div id="tablewrapper">
                    <div id="tableheader">
                        <div class="search">
                            <select id="columns" onchange="sorter.search('query')" class="form-control"></select>
                            <input type="text" id="query" onkeyup="sorter.search('query')" placeholder="Введите слово для поиска"/>
                        </div>
                        <span class="details">
				<div>Записи <span id="startrecord"></span>-<span id="endrecord"></span> из <span id="totalrecords"></span></div>
        		<div><a href="javascript:sorter.reset()">Сбросить</a></div>
        	</span>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" id="table" class="tinytable">
                        <thead>
                        <tr>
                            <th><h3>#</h3></th>
                            <th><h3>Название теста</h3></th>
                            <th><h3>Имя пользователя</h3></th>
                            <th><h3>Дата</h3></th>
                            <th><h3>Время выполнения</h3></th>
                            <th><h3>Результат</h3></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $key=>$result)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$result->test->title}}</td>
                                <td>{{$result->user->fullname}}</td>
                                <td>{{$result->date}}</td>
                                <td>{{$result->time}}</td>
                                <td>
                                    {{$result->result}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div id="tablefooter">
                        <div id="tablenav">
                            <div>
                                <img src="/img/first.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1,true)" />
                                <img src="/img/previous.gif" width="16" height="16" alt="First Page" onclick="sorter.move(-1)" />
                                <img src="/img/next.gif" width="16" height="16" alt="First Page" onclick="sorter.move(1)" />
                                <img src="/img/last.gif" width="16" height="16" alt="Last Page" onclick="sorter.move(1,true)" />
                            </div>
                            <div>
                                <select id="pagedropdown"></select>
                            </div>
                            <div>
                                <a href="javascript:sorter.showall()">view all</a>
                            </div>
                        </div>
                        <div id="tablelocation">
                            <div>
                                <select onchange="sorter.size(this.value)" class="form-control">
                                    <option value="5">5</option>
                                    <option value="10" selected="selected">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span>Записей на страницу</span>
                            </div>
                            <div class="page">Страница <span id="currentpage"></span> из <span id="totalpages"></span></div>
                        </div>
                    </div>
                </div>
                    <link rel="stylesheet" href="/css/table_style.css" />
                    <script type="text/javascript" src="/js/table_script.js"></script>
                    <script type="text/javascript">
                        var sorter = new TINY.table.sorter('sorter','table',{
                            headclass:'head',
                            ascclass:'asc',
                            descclass:'desc',
                            evenclass:'evenrow',
                            oddclass:'oddrow',
                            evenselclass:'evenselected',
                            oddselclass:'oddselected',
                            paginate:true,
                            size:6,
                            colddid:'columns',
                            currentid:'currentpage',
                            totalid:'totalpages',
                            startingrecid:'startrecord',
                            endingrecid:'endrecord',
                            totalrecid:'totalrecords',
                            hoverid:'selectedrow',
                            pageddid:'pagedropdown',
                            navid:'tablenav',
                            sortcolumn:0,
                            sortdir:1,
                            init:true
                        });
                    </script>

                @else
                    <h4> Результатов еще нет </h4>
                @endif
            </section><!-- .app-content -->
        </div>
    </div>
@endsection