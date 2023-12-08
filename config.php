<?php

/* Attempt to connect to MySQL database */
$conexion = mysqli_connect("localhost","root","","inventario");
 
// Check connection
if($conexion === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>