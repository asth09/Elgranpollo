<?php
include("conexion_bd.php");

$usuario=$conexion->real_escape_string($_POST['usuario']);
$password=$conexion->real_escape_string($_POST['password']);

$consulta = "SELECT * FROM usuarios where usuario = '$usuario' and password = '$password' ";
$resultado= mysqli_query($conexion, $consulta);


$filas=mysqli_num_rows($resultado);

if($filas){
    session_start();
    $_SESSION['usuario']=$usuario;
    
    header("location:home.php");
}else{
    include("index.php");
    ?>
    <h1>Error de autenticacion</h1>
        <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
?>