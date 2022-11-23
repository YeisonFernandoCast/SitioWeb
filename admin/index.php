<?php
session_start();
if($_POST){
  if(($_POST['usuario']=="yefer") && ($_POST['contrasenia']=="123456")){  //esta linea se cambiaría por una consulta a la BD
    $_SESSION['usuario']= "ok";
    $_SESSION['nombreUsuario']="yefer";
    header('Location:start.php');
  } else{
    $mensaje="Error, usuario o contraseña son incorrectos";
  } 
}
?>



<!doctype html>
<html lang="en">
  <head>
    <title>Web Site Admin</title>
    <!-- Required meta tags   con b4 $, obtenemos esta estructura lineas 1-16-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
 
  <!-- b4 grid default   y b4 card head-foot, !crt-form-login-->
<div class="container">
    <div class="row">

    <div class="col-md-4">  <!-- me deja centrar el login -->
        
    </div>
        <div class="col-md-5">  

        <br/><br/><br/>    <!-- separación del login de la parte top -->
            <div class="card-body">
                <h3 class="card-header text-center" style= "background-color: rgba(228, 48, 73)">Login</h3>
            <div class="card-body">
                <!-- b4-alert-dafault -->

                  <?php if(isset($mensaje)) { ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo $mensaje?>
                  <?php } ?>
                  </div>
                <form method = "POST">
                    
                  <div class = "form-group">
                  <label >Usuario</label>
                  <input type="text" class="form-control" name="usuario" placeholder="user">
                  <!--<small id="emailHelp" class="form-text text-muted">We'll never share your information with anyone else.</small>-->
                  </div>

                  <div class="form-group">
                  <label >Contraseña</label>
                  <input type="password" class="form-control" name="contrasenia" placeholder="Password">
                  </div>
                  
                  <div class="text-center">
                  <button type="submit" class="btn btn-success">Ingresar</button>
                  <a class="btn btn-danger" href="../products.php" role="button">Mis Cursos</a>
                  </div>
                </form>
                
                
            </div>
            <div class="card-footer text-muted">  <!-- sombra al final del formulario -->
               
            </div>
         </div>  
        
        </div>
        
    </div>
   </div>
  
  </body>
</html>