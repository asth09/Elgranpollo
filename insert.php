<?php
include('conexion_bd.php');
$con = conexion();

$ID = null;
$nombre = $_POST['nombre'];
$rif = $_POST['rif'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$vendedor = $_POST['vendedor'];

$sql = "INSERT INTO clientes VALUES('$ID','$nombre','$rif','$direccion','$telefono','$vendedor')";
$query = mysqli_query($con,$sql);

if($query){
    header("location: home.php");
}
?>