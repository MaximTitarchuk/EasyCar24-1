<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/favicon.ico">

    <title>{{$title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/add.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    <script src="/js/jquery.js"></script>     
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/jq-2.2.0,dt-1.10.11/datatables.min.css"/> 
    <script type="text/javascript" src="https://cdn.datatables.net/t/dt/jq-2.2.0,dt-1.10.11/datatables.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>     

    <link href="/css/lobibox.min.css" rel="stylesheet">
    <script src="/js/notifications.min.js"></script>     

  </head>

  <body>
  

    
    
	@include('layouts.menu')
    


    <div class="container">
        <div class="contentdiv" style="">
            @if (isset($breadcrumbs))
                <div class="page-header">
                    <ol class="breadcrumbCustom">
                        @foreach ($breadcrumbs as $url => $caption)
                            <li><a href="{{$url}}">{!!$caption!!}</a></li>
                        @endforeach
                    </ol>
                </div>
            @endif
            
            @if (Session::has("errorText"))
                <div class="alert alert-danger">
                    {!! SESSION::get("errorText") !!}
                </div>
            @endif