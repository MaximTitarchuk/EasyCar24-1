<!DOCTYPE html>
<html>
    <head>
        <title>EasyCar24</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 48px;
            }

            input {
                text-align: center;
                border: none !important;
            }

            .col-xs-1, .col-xs-2 {
                margin-right: 10px !important;
            }

            #result {
                margin-top: 30px;
                font-size: 27px;
            }

            #result span.success {
                color: #286090;
            }

            #result span.error {
                color: #c9302c;
            }


        </style>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/moment.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <div class="row">
                        <div class="col-xs-1" style="width: 70px">
                            <img src="/images/flag.png" align="absmiddle" />
                        </div>
                        <div class="col-xs-1" style="width: 50px">
                            <input type="text" id="series_prefix" placeholder="А" style="width: 50px" value="" />
                        </div>
                        <div class="col-xs-2" style="width: 120px">
                            <input type="text" id="number" placeholder="777" style="width: 120px" value="" />
                        </div>
                        <div class="col-xs-2" style="width: 80px">
                            <input type="text" id="series_postfix" placeholder="АА" style="width: 80px" value="" />
                        </div>
                        <div class="col-xs-2" style="width: 120px">
                            <input type="text" id="region" placeholder="77" style="width: 120px" value=""  />
                        </div>
                        <div class="col-xs-1" style="width: 70px">
                            <input type="button" class="btn btn-success" value="Найти" id="search" />
                        </div>
                    </div>
                </div>
                <div class="row" id="result">
                </div>

            </div>
        </div>

        <script>
            $(function() {
                $("#search").click(function() {
                    $.post( "/api/v1/cars/search2", { regnumber: $("#series_prefix").val()+$("#number").val()+$("#series_postfix").val()+$("#region").val() })
                            .done(function( data ) {
                                $("#result").html("<span class='success'>Найден телефон:</span> " + data.phone);
                            })
                            .fail(function( data ) {
                                $("#result").html("<span class='error'>"+data.responseJSON.error+"</span>");
                            });
                });
            });
        </script>
    </body>
</html>
