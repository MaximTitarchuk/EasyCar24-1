@include('layouts.header')

@if ($errors->has())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>        
        @endforeach
    </div>
@endif

<form class="form-horizontal" method="post">

    <div class="form-group @if ($errors->has('email')) has-error @endif">
        <label for="email" class="col-sm-3 control-label">Email</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ Illuminate\Support\Facades\Input::old('email', ($edit !== false? $edit->email: "")) }}" />
        </div>
    </div>

    <div class="form-group @if ($errors->has('is_admin')) has-error @endif">
        <label for="email" class="col-sm-3 control-label">Роль</label>
        <div class="col-sm-9">
            <select class="form-control" id="is_admin" name="is_admin">
		<option value="0" @if (Illuminate\Support\Facades\Input::old('is_admin', ($edit !== false? $edit->is_admin: "")) == 0) SELECTED @endif >Промоутер</option>
		<option value="1" @if (Illuminate\Support\Facades\Input::old('is_admin', ($edit !== false? $edit->is_admin: "")) == 1) SELECTED @endif>Администратор</option>
	    </select>
        </div>
    </div>

    <div class="form-group @if ($errors->has('phone')) has-error @endif" style="display: none">
        <label for="phone" class="col-sm-3 control-label">Телефон промоутера</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Телефон промоутера" value="{{ Illuminate\Support\Facades\Input::old('phone', ($edit !== false? $edit->phone: "")) }}" />
        </div>
    </div>

    <div class="form-group @if ($errors->has('pass')) has-error @endif">
        <label for="pass" class="col-sm-3 control-label">Пароль</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="pass" name="pass" placeholder="Пароль" value="" />
        </div>
    </div>
    
    <div class="form-group @if ($errors->has('pass_confirmation')) has-error @endif">
        <label for="pass_confirmation" class="col-sm-3 control-label">Повтор пароля</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="pass_confirmation" name="pass_confirmation" placeholder="Повтор пароля" value="" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}">
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="/systemusers" class="btn btn-danger">Отмена</a>
        </div>
    </div>
</form>
        
<script>
    $(document).ready( function() {
	$("#is_admin").change(function() {
	    if ($(this).val() == 0)
		$("#phone").parent().parent().show();
	    else
		$("#phone").parent().parent().hide();
		
	});

	$("#is_admin").trigger("change");
    });
</script>

@include('layouts.footer')