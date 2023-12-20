<?php
if(!isset($_POST["total"])) exit("No hay total");

session_start();

// Validaciones
$id_usuario = isset($_SESSION["id_usuario"]) ? intval($_SESSION["id_usuario"]) : exit("Usuario no logueado");
$id_cliente = isset($_POST["id_cliente"]) ? intval($_POST["id_cliente"]) : exit("No hay cliente seleccionado");
$total = filter_var($_POST["total"], FILTER_VALIDATE_FLOAT);

include_once "base_de_datos2.php";

// Aquí asumimos que ya has iniciado la sesión y verificado que el usuario está logueado

$ahora = date("Y-m-d H:i:s");

try {
    $base_de_datos->beginTransaction();

    $sentencia = $base_de_datos->prepare("INSERT INTO ventas(fecha, total, id_usuario, id_cliente) VALUES (?, ?, ?, ?);");
    $sentencia->execute([$ahora, $total, $id_usuario, $id_cliente]);

    $sentencia = $base_de_datos->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1;");
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_OBJ);

    $id_venta = $resultado ? $resultado->id : exit("Error al obtener el ID de la venta");

    $sentencia = $base_de_datos->prepare("INSERT INTO producto_venta(id_producto, id_venta, cantidad) VALUES (?, ?, ?);");
    
    foreach ($_SESSION["carrito"] as $producto) {
        // Asegúrate de que 'total' y 'cantidad' son valores numéricos válidos
        $sentencia->execute([$producto->id, $id_venta, $producto->cantidad]);
        
    }

    $base_de_datos->commit();
} catch (Exception $e) {
    $base_de_datos->rollBack();
    exit("Ocurrió un error: " . $e->getMessage());
}

unset($_SESSION["carrito"]);
$_SESSION["carrito"] = [];
header("Location: pedidos.php?status=1");
?>