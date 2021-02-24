@include('layouts.header')

<table id="users" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th class="col-md-1">ID</th>
            <th class="col-md-2">Телефон</th>
            <th class="col-md-2">Баланс</th>
        </tr>
    </thead>
</table>

<script>
    $(function() {
    });
</script>


<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#users').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/promo/data",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'phone', name: 'phone'},
            {data: 'balance', name: 'balance'},
        ],
            language: {
                "emptyTable":     "Данные отсутствуют",
                "info":           "Отображаются записи с _START_ по _END_ (из _TOTAL_ записей)",
                "infoEmpty":      "Отображаются записи с 0 по 0 (из 0 записей)",
                "infoFiltered":   "(отфильтровано из _MAX_ записей)",
                "infoPostFix":    "",
                "thousands":      ".",
                "lengthMenu":     "Вывести _MENU_ записей",
                "loadingRecords": "Загрузка...",
                "processing":     "Обработка...",
                "search":         "Поиск:",
                "zeroRecords":    "Совпадений не найдено",
                "paginate": {
                    "first":      '<i class="fa fa-fast-backward" aria-hidden="true"></i>',
                    "last":       '<i class="fa fa-fast-forward" aria-hidden="true"></i>',
                    "next":       '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    "previous":   '<i class="fa fa-chevron-left" aria-hidden="true"></i>'
                },
                "aria": {
                    "sortAscending":  ": активируйте для сортировки столбца по возрастанию",
                    "sortDescending": ": активируйте для сортировки столбца по убыванию"
                }
            },
    });
});
</script>

@include('layouts.footer')
