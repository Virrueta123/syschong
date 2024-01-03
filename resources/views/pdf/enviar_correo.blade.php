<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ejemplo de Card con Bootstrap</title>
  <link rel="icon" href="{{ asset('images/empresa/logo.png') }}" type="image/png">
  <!-- Enlace al archivo CSS de Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
  <div class="card" style="width: 18rem;">
    <img src="{{asset('/')}}images/empresa/logo.pmg" width="80" class="card-img-top" alt="Imagen">
    <div class="card-body">
      <h5 class="card-title">{{$mensaje}}</h5> 
      <a href="{{$ruta}}" class="btn btn-primary">Mirar Comprobante</a>
    </div>
  </div>
</div>

<!-- Enlace al archivo JS de Bootstrap (requerido para algunos componentes de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>