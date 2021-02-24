@extends('backend.layouts.backend')

@section('title', 'Приглашенные пользователи')

@section('modal')



@endsection

@section('content')
    <button class="btn btn-success btn-rounded btn-ef btn-ef-5 btn-ef-5a mb-10 add-button"><i class="fa fa-plus"></i> <span>Добавить</span></button>
    <form id="edit-data" >
        <table id="list" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Телефон</th>
                <th>Баланс</th>
            </tr>
            </thead>
        </table>
    </form>

    <script>
        $(document).ready(function () {
            oTable = $('#list').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/promo/data",
                "columns": [
                    {data: 'id', name: 'id'},
                    {data: 'phone', name: 'phone'},
                    {data: 'balance', name: 'balance'}
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
                "order": [[0, "asc"]]
            });

        });
    </script>

@endsection