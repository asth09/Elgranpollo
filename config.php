<?php

/* Attempt to connect to MySQL database */
$conexion = mysqli_connect("localhost","bacoopco_inventario","Mysql2023","bacoopco_inventario");
 
// Check connection
if($conexion === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>