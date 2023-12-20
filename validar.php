<?php
include("conexion_bd.php");

$usuario = $conexion->real_escape_string($_POST['usuario']);
$password = $conexion->real_escape_string($_POST['password']);

$consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
$resultado = mysqli_query($conexion, $consulta);

$filas = mysqli_num_rows($resultado);

if ($filas > 0) {
    session_start();
    $fila = mysqli_fetch_assoc($resultado);

    $_SESSION['usuario'] = $usuario;
    $_SESSION['id_usuario'] = $fila['id'];

    if ($fila['id'] == 3) {
        $_SESSION['es_admin'] = true;
    } else {
        $_SESSION['es_admin'] = false;
    }

    header("location:home.php");
} else {
    include("index.php");
    $_SESSION['mensaje'] = "Error: datos incorrectos";
    ?>
    <h1>Error de autenticación</h1>
    <?php
}

mysqli_free_result($resultado);
mysqli_close($conexion);
?>