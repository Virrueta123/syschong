<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <div id="app">
        <pdf-orden-servicio accesorios_selected="{{$accesorios_selected}}" cotizacion="{{$get}}"></pdf-orden-servicio>
    </div>
 
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
