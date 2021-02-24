<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Navigation</span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/projects"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav" style="float:none">
		@if (Auth::user()->is_admin)
        	    <li><a href="/systemusers">Администраторы</a></li>
	    	    <li><a href="/users">Зарегистрированные пользователи</a></li>
		@else
        	    <li><a href="/promo">Приглашенные пользователи</a></li>
		@endif
            </ul>
        </div>
    </div>
</nav>
