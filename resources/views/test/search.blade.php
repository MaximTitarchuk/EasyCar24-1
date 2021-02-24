<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>

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



        </style>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/moment.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <form method="post" action="/api/cars/search">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Рег.номер (Формат А777АА777)</label>
                            <input type="text" class="form-control" name="regnumber" value="О070УО77" />
                        </div>
                        <div class="col-lg-12">
                            <label>Токен</label>
                            <input type="text" class="form-control" name="token" value="jtmEL0deA8oVt7PkzZCnw91tW2XGcDNdeXgYAROymykYc2GcDo" />
                        </div>
                        <div class="col-lg-12">
                            <label>Подпись запроса</label>
                            <input type="text" class="form-control" name="sign" value="35edab90412a652efc436a4e3cb60b4ffaf199da" />
                        </div>
                        <div class="col-lg-12" style="margin-top: 5px">
                            <input type="submit" class="btn btn-success" value="Оправить" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            $(function() {
                $("#search").click(function() {
                    $.post( "/api/cars/search2", { regnumber: $("#series_prefix").val()+$("#number").val()+$("#series_postfix").val()+$("#region").val() })
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
