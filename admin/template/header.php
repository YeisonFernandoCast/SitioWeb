<?php
//validación para saber si hay algún usuario logeado
  session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
  }
  else{
    if($_SESSION['usuario']== "ok"){
      $nombreUsuario=$_SESSION["nombreUsuario"];
    }
  }
?>


<!-- b4 $ -->
<!doctype html>
<html lang="en">
  <head>
    <title>Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

    <?php $url="http://".$_SERVER['HTTP_HOST']."/php-sitioweb2" //Me permite direccionar a la pg principal?> 

      <!-- b4 navbar minimal a -->
  <nav class="navbar navbar-expand color-red bg-light">
    <div class="nav navbar-nav">
        <!--<a class="nav-item nav-link active" href="#">Web Site Admin <span class="sr-only">(current)</span></a>-->
        <a class="nav-item nav-link" href="<?php echo $url;?>/admin/start.php">Inicio</a>
        <!--<a class="nav-item nav-link" href="<?php echo $url;?>/admin/sections/product.php">Libros</a>-->
        <a class="nav-item nav-link" href="<?php echo $url; ?>">Mis Cursos</a>
        <a class="nav-item nav-link" href="<?php echo $url;?>/admin/sections/close.php">Cerrar Sesión</a>
        
    </div>
</nav>
    <!-- b4 grid default -->
    <div class="container">
    <br/><br/>
        <div class="row">
            
            <div class="col-md-12">