<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>@yield('title')</title>
        <link rel="icon" type="image/png" href="/favicon.png" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <link rel="stylesheet" href="{{ elixir('assets/css/backend.css') }}">

        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/js/main.js"></script>
        <script src="/assets/js/new/jquery.inputmask.bundle.min.js"></script>

    </head>

    <body id="minovate" class="appWrapper">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->












        <!-- ====================================================
        ================= Application Content ===================
        ===================================================== -->
        <div id="wrap" class="animsition">






            <!-- ===============================================
            ================= HEADER Content ===================
            ================================================ -->
            <section id="header">
                <header class="clearfix">

                    <!-- Branding -->
                    <div class="branding">
                        <a class="brand" href="/">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </a>
                        <a role="button" tabindex="0" class="offcanvas-toggle visible-xs-inline"><i class="fa fa-bars"></i></a>
                    </div>
                    <!-- Branding end -->






                    <!-- Right-side navigation -->
                    <ul class="nav-right pull-right list-inline">




                        <li class="dropdown nav-profile">

                            <a href class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/assets/images/profile-photo.jpg" alt="" class="img-circle size-30x30">
                                <span>{{ Auth::user()->email }}
                            </a>


                        </li>

                    </ul>
                    <!-- Right-side navigation end -->



                </header>

            </section>
            <!--/ HEADER Content  -->





            <!-- =================================================
            ================= CONTROLS Content ===================
            ================================================== -->
            <div id="controls">





                <!-- ================================================
                ================= SIDEBAR Content ===================
                ================================================= -->
                <aside id="sidebar">


                    <div id="sidebar-wrap">

                        <div class="panel-group slim-scroll" role="tablist">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#sidebarNav">
                                            Навигация <i class="fa fa-angle-up"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div id="sidebarNav" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body">


                                        <!-- ===================================================
                                        ================= NAVIGATION Content ===================
                                        ==================================================== -->
                                        <ul id="navigation">
                                            @if (Auth::user()->is_admin == 1)
                                                <li @if(Request::is('dashboard')) class="active" @endif><a href="/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                                                <li>
                                                    <a role="button" tabindex="0"><i class="fa fa-users"></i> <span>Пользователи системы</span></a>
                                                    <ul>
                                                        <li @if(Request::is('systemusers')) class="active" @endif><a href="/systemusers"><i class="fa fa-user-secret"></i> Администраторы</a></li>
                                                        <li @if(Request::is('systemusers/promoter')) class="active" @endif><a href="/systemusers/promoter"><i class="fa fa-user"></i> Промоутеры</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a role="button" tabindex="0"><i class="fa fa-desktop"></i> <span>Система</span></a>
                                                    <ul>
                                                        <li @if(Request::is('users')) class="active" @endif><a href="/users"><i class="fa fa-users"></i> Пользователи системы</a></li>
                                                        <li @if(Request::is('specials')) class="active" @endif><a href="/specials"><i class="fa fa-rub"></i> Специальные предложения</a></li>
                                                    </ul>
                                                </li>
                                            @else
                                                <li @if(Request::is('promo')) class="active" @endif><a href="/promo"><i class="fa fa-user"></i> Рефереры</a></li>
                                            @endif



                                        </ul>
                                        <!--/ NAVIGATION Content -->


                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </aside>
                <!--/ SIDEBAR Content -->







            </div>
            <!--/ CONTROLS Content -->




            <!-- ====================================================
            ================= CONTENT ===============================
            ===================================================== -->
            <section id="content-page">

                <div class="page page-dashboard">


                    <div class="pageheader">

                        <div class="page-bar">

                            @if (isset($breadcrumb))
                                <ul class="page-breadcrumb">
                                    <li>
                                        <a href="/"><i class="fa fa-home"></i> {{ config("app.name") }}</a>
                                    </li>
                                    @foreach ($breadcrumb as $url=>$title)
                                        <li>
                                            <a href="{{ $url }}"> {{ $title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>

                    </div>



                    @yield('content')




                </div>

                
            </section>
            <!--/ CONTENT -->






        </div>
        <!--/ Application Content -->

        @yield('modal')

        <script src="{{ elixir('assets/js/backend.js') }}"></script>

    </body>
</html>
