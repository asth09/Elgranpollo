<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"], $_POST["entradas"], $_POST["observacion"], $_POST["id_usuario"])) {
        // Incluir el archivo de conexión a la base de datos
        include_once "base_de_datos.php";

        // Recoger los datos del formulario
        $nombre = $_POST["nombre"];
        $entradas = $_POST["entradas"];
        $observacion = $_POST["observacion"];
        $id_usuario = $_POST["id_usuario"];

        // Obtener la fecha actual
        $fecha = date("Y-m-d H:i:s");

        try {
            $base_de_datos->beginTransaction();

            // Insertar los datos en la tabla "entradas"
            $sentencia = $base_de_datos->prepare("INSERT INTO entradas (fecha, nombre, entradas, observacion, id_usuario) VALUES (?, ?, ?, ?, ?)");
            $sentencia->execute([$fecha, $nombre, $entradas, $observacion, $id_usuario]);

            $base_de_datos->commit();

            // Redirigir a una página de éxito u otro lugar después de la inserción
            header("Location: entradas_aux.php?status=1");
            exit();
        } catch (Exception $e) {
            $base_de_datos->rollBack();
            exit("Ocurrió un error: " . $e->getMessage());
        }
    } else {
        exit("No se han proporcionado todos los datos necesarios");
    }
} else {
    exit("Acceso denegado");
}
?>