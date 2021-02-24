@extends('backend.layouts.backend')

@section('title', 'Пользователи системы')

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
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-success">
                                    <input type="radio" name="is_active" autocomplete="off" value="1"> Активен
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" name="is_active" autocomplete="off" value="0"> Не активен
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Имя">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Телефон">
                        </div>

                        <div class="form-group">
                            <label for="system_user_id">Промоутер</label>
                            <select class="form-control" id="system_user_id" name="system_user_id">

                            </select>
                        </div>

                        <input type="hidden" name="id" id="id" value="" />
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="id" value="" />
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

    <div class="modal splash fade" id="comments" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-options="splash-2 splash-slategray splash-ef-13">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font">Комментарии к пользователю</h3>
                </div>
                <div class="modal-body">
		    <ul class="content chats p-0">
		    </ul>
                    <form role="form">
                        <input type="text" class="form-control" id="comment-text" placeholder="Введите новый комментарий" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c" id="comments-add-button"><i class="fa fa-arrow-right"></i> Добавить</button>
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
    <style>
        #user-search tbody tr, #user-payment tbody tr {
            background-color: #3f4e62;
        }

        #user-search .paginate_button:not(.active) a, #user-payment .paginate_button:not(.active) a {
            background-color: #3f4e62;
        }

        #user-search .paginate_button a, #user-payment .paginate_button a {
            border: #3f4e62;
        }

    </style>
    <button class="btn btn-success btn-rounded btn-ef btn-ef-5 btn-ef-5a mb-10 add-button"><i class="fa fa-plus"></i> <span>Добавить</span></button>
    <form id="edit-data" 
	data-save-action="/users/save" 
	data-delete-action="/users/delete" 
	data-info-action="/users/info" 
	data-balance-action="/users/balance" 
	data-stats-action="/users/stats" 
	data-comments-action="/users/comments" 
	data-comments-add-action="/users/comments/add" 
    >
        <table id="list" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Телефон</th>
                <th>Регион</th>
                <th>Авто</th>
                <th width="150">Баланс</th>
                <th width="150">Дата регистрации</th>
                <th width="180"></th>
            </tr>
            </thead>
        </table>
    </form>

    <script>
        var userSearchTable;
        var userPaymentTable;

        $(document).ready(function () {
            oTable = $('#list').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/users/data",
                "columns": [
                    {data: 'phone', name: 'phone'},
                    {data: 'region', name: 'region'},
                    {data: 'regnumber', name: 'regnumber'},
                    {data: 'balance', name: 'balance'},
                    {data: 'created_at', name: 'created_at'},
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
                "aaSorting": [[3, "desc"]],
                "order": [[3, "desc"]],
                "columnDefs": [
                    {
                        "targets": [5],

                        "searchable": false,
                        "orderable": false
                    }
                ]

            });

            $("input[type='tel']").inputmask("(999) 999-9999");

            $("body").on("click", ".balance-button", function () {
                $("#balance-add-button").attr("data-id", $(this).data("id"));
                $("#balance").modal("show");
            });

            $("#balance-add-button").click(function () {
                var id = $(this).data("id");

                $.getJSON( $("#edit-data").data("balance-action"), {id: id, balance: $("#balance-sum").val() })
                        .done(function( data ) {
                            toastr.success('Платеж успешно проведен', 'Пополнение баланса', toastrOptions);
                            oTable.ajax.reload( null, false );
                            $("#balance").modal("hide");
                        });
            });

            $("body").on("click", ".stats-button", function () {
                var id = $(this).data("id");

                userSearchTable = $('#user-search-table').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/users/stats/search?id=" + id,
                    "columns": [
                        {data: 'regnumber', name: 'regnumber'},
                        {data: 'found', name: 'found'},
                        {data: 'cost', name: 'cost'},
                        {data: 'type', name: 'type'},
                        {data: 'paid', name: 'paid'},
                        {data: 'created_at', name: 'created_at'},
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
                    "aaSorting": [[5, "desc"]],
                    "order": [[5, "desc"]],
                    "columnDefs": [
                        {
                        }
                    ]

                });

                userPaymentTable = $('#user-payment-table').DataTable({
                    "destroy": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "/users/stats/payment?id=" + id,
                    "columns": [
                        {data: 'balance', name: 'balance'},
                        {data: 'paid', name: 'paid'},
                        {data: 'description', name: 'description'},
                        {data: 'updated_at', name: 'updated_at'},
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
                    "aaSorting": [[3, "desc"]],
                    "order": [[3, "desc"]],
                    "columnDefs": [
                        {
                        }
                    ]

                });

                $("#stats").modal("show");


            });

	    $("#list").on("click", ".comments-button", function () {
	        var id = $(this).data("id");

		$("#comment-text").val("");

	        $("#comments #comments-add-button").attr("data-id", id);

	        $.getJSON( $("#edit-data").data("comments-action"), {id: id})
	            .done(function( data ) {
			$("#comments .content").html(data.content);
	                $("#comments").modal("show");
	            })
	            .fail(function(data) {
	                var error = "";
	                $.each(data.responseJSON, function(idx, e) {
	                    error += e+'<br/>';
	                });
	                toastr.error(error, 'Ошибка', toastrOptions);
	            });
	    });


	    $("#comments-add-button").click(function () {
		var id = $(this).attr("data-id");

		$("#comment-text").parent().removeClass("has-error");

		if ($("#comment-text").val().trim() == "") {
		    $("#comment-text").parent().addClass("has-error");
		    toastr.error('Введите текст комментария', 'Ошибка', toastrOptions);
		    return;
		}

		var data = {};
		data["user_id"]	= id;
		data["comment"]	= $("#comment-text").val().trim();
		data["_token"] 	= $('meta[name="csrf-token"]').attr('content');

		$.ajax({
	            url: $("#edit-data").data("comments-add-action"),
	            data: data,
	            method: 'POST'
	        }).done(function() {
	            toastr.success('Данные успешно сохранены', 'Сохранение', toastrOptions);
	            oTable.ajax.reload( null, false );
	            $("#comments").modal("hide");
	        })
	        .fail(function(data) {
	            var error = "";
	            $.each(data.responseJSON, function(idx, e) {
	                error += e+'<br/>';
	            });
	            toastr.error(error, 'Ошибка', toastrOptions);
	        });

	    });
        });
    </script>

@endsection