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

	<script>
	    function appDetect ()
	    {
	    	var agent = navigator.userAgent.toLowerCase();
	    	var type;
	    
	    	var android = iphone = false;
	    
	    	if (agent.indexOf('iphone') != -1) {
	    	    type = 'iPhone';
	    	    iphone = true;
	    	} else if (agent.indexOf('ipod') != -1) {
	    	    type = 'iPod Touch';
	    	    iphone = true;
	    	} else if (agent.indexOf('ipad') != -1) {
	    	    type = 'iPad';
	    	    iphone = true;
	    	} else if (agent.indexOf('android') != -1) {
	    	    android = true;
	    	} else {
	    	    return;
	    	}

	    	if (android) {
	    	    window.location.href = "https://play.google.com/store/apps/details?id=ksri.info.easycar24";
	    	} else if (iphone) {
	    	    window.location.href = "https://itunes.apple.com/us/app/easycar24/id1116729990?l=ru&ls=1&mt=8";
	    	}
		else
		    window.location.href = "/";
	    }

	    appDetect();
	</script>
    </head>
    <body>
        <div class="container">
            <div class="content">

            </div>
        </div>

    </body>
</html>
