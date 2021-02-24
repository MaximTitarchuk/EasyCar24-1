@extends('backend.layouts.backend')

@section('title', 'Администраторы')

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
                                    <input type="radio" name="is_admin" autocomplete="off" value="1"> Администратор
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" name="is_admin" autocomplete="off" value="0"> Промоутер
                                </label>
                            </div>
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
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль для изменения">
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

    <div class="modal splash fade" id="stats" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-options="splash-2 splash-slategray splash-ef-13">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font">Статистика</h3>
                </div>
                <div class="modal-body" >

                </div>
                <div class="modal-footer">
                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal splash fade" id="remove" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-options="splash-2 splash-ef-6">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title custom-font">Удаление пользователя</h3>
                </div>
                <div class="modal-body text-center">
                    Вы действительно хотите удалить этого пользователя?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-ef btn-ef-3 btn-ef-3c remove-сonfirm-button"><i class="fa fa-arrow-right"></i> Удалить</button>
                    <button class="btn btn-default btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Отмена</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('content')
    <button class="btn btn-success btn-rounded btn-ef btn-ef-5 btn-ef-5a mb-10 add-button"><i class="fa fa-plus"></i> <span>Добавить</span></button>
    <form id="edit-data"
          data-save-action="/systemusers/save"
          data-delete-action="/systemusers/delete"
          data-info-action="/systemusers/info"
          data-stats-action="/systemusers/stats"
    >
        <table id="list" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Email</th>
                @if ($is_admin == 0)
                    <th width="200">Количество рефералов</th>
                    <th width="200">Баланс пополнения</th>
                @endif
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
                "ajax": "/systemusers/data/{{ $is_admin }}",
                "columns": [
                    {data: 'email', name: 'email'},
                    @if ($is_admin == 0)
                        {data: 'countRef', name: 'countRef'},
                        {data: 'balance', name: 'balance'},
                    @endif
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
                "aaSorting": [[0, "asc"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {
                        @if ($is_admin == 0)
                            "targets": [2],
                        @else
                            "targets": [1],
                        @endif

                        "searchable": false,
                        "orderable": false
                    }
                ]

            });

            $("input[type='tel']").inputmask("(999) 999-9999");


        });

        $("#list").on("click", ".stats-button", function () {
            var id = $(this).data("id");

            $.getJSON( $("#edit-data").data("stats-action"), {id: id})
                    .done(function( data ) {

                        $("#stats .modal-body").html(data.result);

                        $('.easypiechart').each(function() {
                            var element = $(this);
                            element.easyPieChart({
                                onStart: function(value) {
                                    if (element.hasClass('animate')) {
                                        $(this.el).find('span').countTo({to: value});
                                    }
                                }
                            });
                        });

                        $("#stats").modal("show");
                    })
                    .fail(function(data) {
                        var error = "";
                        $.each(data.responseJSON, function(idx, e) {
                            error += e+'<br/>';
                        });
                        toastr.error(error, 'Ошибка', toastrOptions);
                    });
        });

    </script>

@endsection