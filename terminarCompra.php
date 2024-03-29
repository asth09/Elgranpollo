<?php
if(!isset($_POST["total"])) exit("No hay total");

session_start();

// Validaciones
$id_usuario = isset($_SESSION["id_usuario"]) ? intval($_SESSION["id_usuario"]) : exit("Usuario no logueado");
$id_proveedor = isset($_POST["id_proveedor"]) ? intval($_POST["id_proveedor"]) : exit("No hay proveedor seleccionado");
$total = filter_var($_POST["total"], FILTER_VALIDATE_FLOAT);

include_once "base_de_datos.php";

// Aquí asumimos que ya has iniciado la sesión y verificado que el usuario está logueado

$ahora = date("Y-m-d H:i:s");

try {
    $base_de_datos->beginTransaction();

    $sentencia = $base_de_datos->prepare("INSERT INTO compras(fecha, total, id_usuario, id_proveedor) VALUES (?, ?, ?, ?);");
    $sentencia->execute([$ahora, $total, $id_usuario, $id_proveedor]);

    $sentencia = $base_de_datos->prepare("SELECT id FROM compras ORDER BY id DESC LIMIT 1;");
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

    $id_compra = $resultado ? $resultado->id : exit("Error al obtener el ID de la venta");

    $sentencia = $base_de_datos->prepare("INSERT INTO provee_compra(id_producto, id_compra, cantidad) VALUES (?, ?, ?);");
    $sentenciaExistencia = $base_de_datos->prepare("UPDATE producto SET existencia = existencia + ? WHERE id = ?;");

    foreach ($_SESSION["carrito"] as $producto) {
        // Asegúrate de que 'total' y 'cantidad' son valores numéricos válidos
        $sentencia->execute([$producto->id, $id_compra, $producto->cantidad]);
        $sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
    }

    $base_de_datos->commit();
} catch (Exception $e) {
    $base_de_datos->rollBack();
    exit("Ocurrió un error: " . $e->getMessage());
}

unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: comprar.php?status=1");
?>