<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Error 404</title>
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">
        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Orbitron', sans-serif;
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
                font-size: 52px;
                margin-bottom: 40px;
            }
            .link{
                font-size: 20px;
                color: black;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Error 404, la página solicitada no existe</div>
                <a class="link" href="{{ route('safd.index') }}">Regresar a la página de inicio</a>
            </div>
        </div>
    </body>
</html>
