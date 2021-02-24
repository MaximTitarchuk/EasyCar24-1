@extends('backend.layouts.backend')

@section('title', 'Специальные приложения')

@section('modal')
    <div class="modal splash fade" id="edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-options="splash-2 splash-slategray splash-ef-13">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font"></h3>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group">
                            <label for="date_from">Начало диапазона</label>
                            <input type="text" class="form-control" id="date_from" name="date_from" placeholder="Начало диапазона в формате ДД.ММ.ГГГГ ЧЧ:ММ:СС">
                        </div>

                        <div class="form-group ">
                            <label for="date_to">Окончание диапазона</label>
                            <input type="text" class="form-control" id="date_to" name="date_to" placeholder="Окончание диапазона в формате ДД.ММ.ГГГГ ЧЧ:ММ:СС">
                        </div>

                        <div class="form-group">
                            <label for="sum_from">От суммы</label>
                            <input type="text" class="form-control" id="sum_from" name="sum_from" placeholder="Введите сумму">
                        </div>

                        <div class="form-group">
                            <label for="sum_to">До суммы</label>
                            <input type="text" class="form-control" id="sum_to" name="sum_to" placeholder="Введите сумму">
                        </div>

                        <div class="form-group">
                            <label for="percent">Процент</label>
                            <input type="text" class="form-control" id="percent" name="percent" placeholder="Процент">
                        </div>

                        <div class="form-group">
                            <label for="content">Описание</label>
                            <input type="text" class="form-control" id="content" name="content" placeholder="Описание">

                        </div>

                        <input type="hidden" name="id" id="id" value="" />
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="token" id="token" value="" />
                    <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c save-button"><i class="fa fa-arrow-right"></i> Сохранить</button>
                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Отмена</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal splash fade" id="balance" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-options="splash-2 splash-slategray splash-ef-13">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font">Пополнение баланса</h3>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <input type="text" class="form-control" id="balance-sum" placeholder="Введите сумму" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" id="balance-add-button"><i class="fa fa-arrow-right"></i> Сохранить</button>
                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Отмена</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal splash fade" id="stats" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-options="splash-2 splash-slategray splash-ef-13">
        <div class="modal-dialog modal-lg-big">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font"></h3>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="col-xs-12">
                            <ul class="nav nav-tabs tabs-dark">
                                <li class="active"><a href="#user-search" data-toggle="tab" aria-expanded="false">Поисковые запросы</a></li>
                                <li><a href="#user-payment" data-toggle="tab" aria-expanded="false">Платежи пользователя</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12">
                            <div class="tab-content">
                                <div class="tab-pane active" id="user-search">
                                    <table id="user-search-table" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Регистрационный номер авто</th>
                                            <th>Статус поиска</th>
                                            <th>Цена запроса</th>
                                            <th>Тип запроса</th>
                                            <th>Оплата</th>
                                            <th>Дата запроса</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane" id="user-payment">
                                    <table id="user-payment-table" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Баланс пополнения</th>
                                            <th>Статус оплаты</th>
                                            <th>Описание операции</th>
                                            <th>Дата оплаты</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Отмена</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')
    <button class="btn btn-success btn-rounded btn-ef btn-ef-5 btn-ef-5a mb-10 add-button"><i class="fa fa-plus"></i> <span>Добавить</span></button>
    <form id="edit-data" data-save-action="/specials/save" data-delete-action="/specials/delete" data-info-action="/specials/info" >
        <table id="list" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Диапазон дат</th>
                <th>Диапазон сумм</th>
                <th width="100">Процент</th>
                <th width="150"></th>
            </tr>
            </thead>
        </table>
    </form>

    <script>
        $(document).ready(function () {
            oTable = $('#list').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/specials/data",
                "columns": [
                    {data: 'dates', name: 'dates'},
                    {data: 'sums', name: 'sums'},
                    {data: 'percent', name: 'percent'},
                    {data: 'actions', name: 'actions'}
                ],
                language: {
                    "emptyTable": "Данные отсутствуют",
                    "info": "Отображаются записи с _START_ по _END_ (из _TOTAL_ записей)",
                    "infoEmpty": "Отображаются записи с 0 по 0 (из 0 записей)",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": "Вывести _MENU_ записей",
                    "loadingRecords": "Загрузка...",
                    "processing": "Обработка...",
                    "search": "Поиск:",
                    "zeroRecords": "Совпадений не найдено",
                    "paginate": {
                        "first": '<i class="fa fa-fast-backward" aria-hidden="true"></i>',
                        "last": '<i class="fa fa-fast-forward" aria-hidden="true"></i>',
                        "next": '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                        "previous": '<i class="fa fa-chevron-left" aria-hidden="true"></i>'
                    },
                    "aria": {
                        "sortAscending": ": активируйте для сортировки столбца по возрастанию",
                        "sortDescending": ": активируйте для сортировки столбца по убыванию"
                    }
                },
                iDisplayLength: 25,
                "aaSorting": [[0, "desc"]],
                "order": [[0, "desc"]],
                "columnDefs": [
                    {
                        "targets": [3],

                        "searchable": false,
                        "orderable": false
                    }
                ]

            });

        });
    </script>

@endsection