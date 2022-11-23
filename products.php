<?php include("templates/header.php"); ?>

<?php
include("admin/config/db.php");
$sentenciaSQL=$conexion->prepare("SELECT * FROM productos ORDER BY id DESC");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<?php foreach($listaProductos as $producto) { ?> 

   
    <div class="col-md-3">   
    <div class="card">
    <img class="card-img-top" src="./img/<?php echo $producto['imagen'];?>" alt="">
        <div class="card-body">
        <p class="card-title"><?php echo $producto['nombre'];?></p>
        <!--<a name="" id="" class="btn btn-primary" href="https://www.areatecnologia.com/informatica/lenguajes-de-programacion.html" role="button">More</a>-->
        </div>
    </div>
</div>
<?php } ?>

<?php include("templates/footer.php"); ?>

<!-- usando b4, obtengo el card, col, boton-->