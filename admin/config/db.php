<?php

// variables para la conexión a la BD
$host="localhost";
$db="sitio";
$usuario="root";
$contrasenia="";

//PDO para la comunicación con la BD, validacion si hay conexión o de lo contrario mostrar un mensaje de error
try{
    $conexion=new PDO("mysql:host=$host;dbname=$db",$usuario,$contrasenia);
    //if($conexion){ echo "Conectado... al Sitio ";}

} catch (Exception $ex){
    echo $ex->getMessage();
}

?>