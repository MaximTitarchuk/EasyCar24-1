@include('layouts.header')

<table class="table table-striped">
    <thead>
        <tr>
            <th>Email</th>
            <th style="width: 150px">Роль</th>
            <th style="width: 100px">

            </th>
        </tr>
    </thead>
	
    @if (count($rowset) == 0) 
        <tr>
            <td colspan="2">Данные не найдены</td>
        </tr>
    @else
        @foreach($rowset as $row)
            <tr>
                <td>{!! $row->email !!}</td>
                <td>@if($row->is_admin) <span class="label label-success">Администратор</span> @else <span class="label label-default">Промоутер</span> @endif</td>
                <td class="text-right">
                    <a href="/systemusers/{{$row['id']}}/edit" class="btn btn-xs btn-primary" title="Изменить данные пользователя">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="btn btn-danger btn-xs deletePage" data-toggle="modal" data-target="#deletePage" title="Удалить пользователя" wid="{{$row['id']}}" @yield('disabled')>
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td colspan="3"><a class="btn btn-xs btn-success" href="/systemusers/create">Добавить</a></td>
    </tr>
</table>


<div class="modal fade" id="deletePage" tabindex="-1" role="dialog" aria-labelledby="myDeletePageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myDeletePageLabel">Удаление</h4>
            </div>
            <div class="modal-body">
                Вы действительно хотите удалить этого пользователя?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
              <a href="" id="deleteLink" class="btn btn-danger">Удалить</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        $(".deletePage").on("click", function () {
            $("#deleteLink").attr("href", "/systemusers/"+$(this).attr("wid")+"/delete");
        });
        
        $("#deleted").on("change", function() {
            if ($(this).prop("checked"))
                $(".deleted").removeClass("hidden");
            else
                $(".deleted").addClass("hidden");
        });
    });
</script>

@include('layouts.footer')
