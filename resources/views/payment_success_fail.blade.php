
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie ie9" lang="en" class="no-js"> <![endif]-->
<!--[if !(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <title>EasyCar24</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Определение номера сотового владельца по номеру авто">

    <link rel="icon" type="image/png" href="/favicon.png" />

    <!-- CSS -->
    <link href="/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/main.css" rel="stylesheet" type="text/css">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Dosis:200,300,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>

</head>
<body>	<!-- PAGE PRELOADER -->
    <div id="preloader">
	<div class="loader-wrapper">
	    <img src="/assets/img/loader.gif" alt="Zi" />
	    <span>Загрузка ...</span>
	</div>
    </div>
    <!-- END PAGE PRELOADER -->	<!-- WRAPPER -->
    <div class="wrapper">

	<!-- HEADER 
	<header class="navbar navbar-fixed-top navbar-default">
	    <div class="container">
		<div class="navbar-header">
		    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
			<span class="sr-only">Показать меню</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		    </button>
		    <a href="#top" class="navbar-brand navbar-logo">
			<img src="/assets/img/zi-logo-header.png" alt="Zi - Simple Landing Page">
		    </a>
		</div>
		<nav id="navigation" class="navbar-collapse collapse">
		    <ul class="nav navbar-nav navbar-right">
			<li><a href="#top">Скачать</a></li>
			<li><a href="#howitworks">О приложении</a></li>
			<li><a href="#features">Возможности</a></li>
			<li><a href="#screenshots">Скриншоты</a></li>
			<li><a href="#reviews">Отзывы</a></li>
		    </ul>
		</nav>
	    </div>
	</header>
	<!-- END HEADER -->

	<!-- HERO SECTION -->
	<section id="top" class="hero-unit fullscreen-image-bg clearfix" style="margin-bottom:0;">
	    <div class="container text-center">
		    <h1>Пополнение счёта приложения EasyCar24</h1>

		    <div class="alert @if(Request::segment(2) == "success") alert-success @else alert-danger @endif">
			@if(Request::segment(2) == "success")
			    Операция успешно завершена!
			@else
			    При оплате произошла ошибка!
			@endif
		    </div>
		
	    </div>
	</section>
	<!-- END HERO SECTION -->
	
	<!-- END FOOTER -->
    </div>
    <!-- END WRAPPER -->

    <div class="back-to-top">
	<a href="#top"><i class="fa fa-angle-up"></i></a>
    </div>

    <!-- JAVASCRIPTS -->
    <script src="/assets/js/jquery-2.1.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.easing.min.js"></script>
    <script src="/assets/js/plugins/fitvids/jquery.fitvids.js"></script>
    <script src="/assets/js/plugins/bxslider/jquery.bxslider.js"></script>
    <script src="/assets/js/plugins/slick/slick.js"></script>
    <script src="/assets/js/plugins/localscroll/jquery.scrollTo-1.4.3.1-min.js"></script>
    <script src="/assets/js/plugins/localscroll/jquery.localscroll-1.2.7-min.js"></script>
    <script src="/assets/js/plugins/wow/wow.min.js"></script>
    <script src="/assets/js/zi-script.js"></script>
    <script src="/assets/js/zi-newsletter.js"></script>
    <script src="/assets/js/plugins/inputmask/inputmask.min.js"></script>
    <script src="/assets/js/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="/assets/js/plugins/inputmask/inputmask.extensions.min.js"></script>
    <script src="/assets/js/plugins/inputmask/inputmask.phone.extensions.min.js"></script>

    <script>
	$(document).ready(function(){
	    $('[name="phone"]').inputmask("(999) 999-99-99");
	});
    </script>

</body>
</html>





