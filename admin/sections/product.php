<?php include ("../template/header.php"); 
//Valida si llega la información
//<?php print_r($_POST);
//<?php print_r($_FILES);
//Array ( [txtId] => [txtNombre] => PHP [action] => Agregar ) 
//Array ( [txtImagen] => Array ( [name] => four.png [type] => image/png [tmp_name] 
//=> C:\wamp64\tmp\phpECA0.tmp [error] => 0 [size] => 27666 ) )


// validacion de recepcion de información
// isset, valida si hay datos
// si hay algo en txtId, se asigna a la variable $txtID, de lo contrario almacena vacio
$txtId=(isset($_POST['txtId']))?$_POST['txtId']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


//echo $txtId."<br/>";
//echo $txtNombre."<br/>";
//echo $txtImagen."<br/>";
//echo $accion."<br/>";

include ("../config/db.php"); // para conectarme al archivo db.php de la Base de Datos

//inicio de CRUD
switch($accion){

    case "Agregar":
        echo "Registro Agregado";
        $sentenciaSQL=$conexion->prepare("INSERT INTO productos (nombre, imagen) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindparam(':nombre',$txtNombre);

        //subir imágen a la carpeta img  
        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        $sentenciaSQL->bindparam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();
        header("Location:product.php");
         break;
        }

    case "Modificar":
        $sentenciaSQL=$conexion->prepare("UPDATE productos set nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':id',$txtId);
        $sentenciaSQL->execute();

            //modificación para la imágen, validando si existe alguna img
        if($txtImagen!=""){

            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            // renombrar y mover a la carpeta img
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            //se busca la img antigua para borrarla
            $sentenciaSQL=$conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtId);
            $sentenciaSQL->execute();
            $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if(isset($producto["imagen"]) && ($producto["imagen"]!="imagen.jpg")) {
                if(file_exists("../../img/".$producto["imagen"])){
                    unlink("../../img/".$producto["imagen"]);
                }
            }

            // actualizamos con la img nueva
            $sentenciaSQL=$conexion->prepare("UPDATE productos set imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtId);
            $sentenciaSQL->execute();
        }
        echo "Registro modificado";
        header("Location:product.php");
        break;


    case "Cancelar":
        header("Location:product.php");
        echo "Acción cancelada";
        break;
    

    case "Seleccionar":
        $sentenciaSQL=$conexion->prepare("SELECT * FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtId);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //carga registros de la tabla a datos de producto

        $txtNombre=$producto['nombre'];
        $txtImagen=$producto['imagen'];
        echo "Registro seleccionado";
        break;
    

    case "Borrar":
        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtId);
        $sentenciaSQL->execute();
        $producto=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if(isset($producto["imagen"]) && ($producto["imagen"]!="imagen.jpg")) {
            if(file_exists("../../img/".$producto["imagen"])){
                unlink("../../img/".$producto["imagen"]);
            }
        }

        $sentenciaSQL=$conexion->prepare("DELETE FROM productos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtId);
        $sentenciaSQL->execute();    
        echo "Registro Borrado";
        header("Location:product.php");
        break;

}


//Mostrar Productos en la tabla
$sentenciaSQL=$conexion->prepare("SELECT * FROM productos ORDER BY id DESC");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC); // Seleccionamos todo lo que hay en la tabla y fetchAll recupera todo. FETCH_ASSOC, genera una asociación de registros


?>


<!--b4-grid-container , !crt-form-login-->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!--b4 card-head-foot-->
        <div class="card">
            <div class="card-header">
                Ingresar Curso
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data"> 

                    <div class = "form-group">
                    <label for="txtId">Id</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtId; ?>" name="txtId" id="txtId" placeholder="id"/>
                    </div>

                    <div class = "form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del curso"/>
                    </div>

                    <div class = "form-group">
                    <label for="txtNombre">Imágen</label>
                    <br/>

                    <?php   if($txtImagen!=""){   ?>
                        
                        <img  class="img-thumbail rounded" src="../../img/<?php echo $txtImagen;?>" width="60" alt="">

                    <?php } ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="imagen"/>
                    </div>

                    <!--b4-bgroup-default-->
                    <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo($accion == "Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo($accion != "Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo($accion != "Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-success">Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    
    
        </div>

        <div class="col-md-8">
            <!--b4 table-default-->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre Curso</th>
                        <th>Imágen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaProductos AS $producto){ ?>
                    <tr>
                        <td><?php echo $producto["id"];?></td>
                        <td><?php echo $producto["nombre"];?></td>
                        <td>
                         <img class="img-thumbail rounded" src="../../img/<?php echo $producto["imagen"];?>" width="60" alt="">   
                        </td>
                        <td>
                    
                            <form method="post">
                                <input type="hidden" name="txtId" id="txtId" value="<?php echo $producto["id"]; ?>"/>
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                            </form>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>   


<?php include ("../template/footer.php");?>