@include('layouts.header')

<table id="users" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th class="col-md-1">ID</th>
            <th class="col-md-2">Имя</th>
            <th class="col-md-2">Email</th>
            <th class="col-md-2">Телефон</th>
            <th class="col-md-2">Баланс</th>
            <th class="col-md-2">Создание</th>
            <th class="col-md-2"></th>
        </tr>
    </thead>
</table>

<div class="modal fade" id="BalanceBlock" tabindex="-1" role="dialog" aria-labelledby="BalanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="BalanceLabel">Пополнение баланса</h4>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="balance" placeholder="Введите сумму" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              <button type="button" id="BalanceLink" class="btn btn-success">Пополнить</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {



        $("body").on("click", ".balance", function () {
            $("#BalanceLink").attr("data-id", $(this).data("id"));
	        $("#BalanceBlock").modal("show");
        });

        $("#BalanceLink").on("click", function() {
	    $.post( "/users/"+$(this).data("id")+"/balance", { balance: $("#balance").val() })
	    .done(function( data ) {
		oTable.ajax.reload( null, false );

		$("#balance").val("");
	        $("#BalanceBlock").modal("hide");

		Lobibox.notify('success', {
		    size: 'mini',
		    icon: false,
		    rounded: false,
		    delayIndicator: true,
		    position: 'center top',
		    msg: 'Данные обновлены'
		});
	    })
	    .fail(function( data ) {
		Lobibox.notify('error', {
		    size: 'mini',
		    icon: false,
		    rounded: false,
		    delayIndicator: true,
		    position: 'center top',
		    msg: data.responseText
		});
	    });
        });
    });
</script>


<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#users').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "/users/data",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'balance', name: 'balance'},
            {data: 'created_at', name: 'created_at'},
	    {data: 'actions', name: 'actions'}
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
