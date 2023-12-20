<?php
// Primero, asegúrate de que se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conecta a la base de datos (si no lo has hecho ya)
    $conn = new mysqli("localhost", "root", "", "registro");

    // Verifica si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtiene los datos del pedido a partir del ID del pedido enviado desde el formulario
    $ventas_id = $_POST['ventas_id'];
    $sql_ventas = "SELECT * FROM ventas WHERE id = $ventas_id";
    $resultado_ventas = $conn->query($sql_ventas);
    $ventas = $resultado_ventas->fetch_assoc();

    // Inserta los datos del pedido en la tabla de compras
    $sql_compra = "INSERT INTO compras (producto_id, cantidad, precio) VALUES ('{$pedido['producto_id']}', '{$pedido['cantidad']}', '{$pedido['precio']}')";
    if ($conn->query($sql_compra) === TRUE) {
        echo "El pedido se ha convertido en compra y se ha registrado correctamente";
    } else {
        echo "Error al convertir el pedido en compra: " . $conn->error;
    }

    // Descuenta la cantidad de productos del inventario
    $producto_id = $pedido['producto_id'];
    $cantidad = $pedido['cantidad'];
    $sql_descuento = "UPDATE inventario SET cantidad = cantidad - $cantidad WHERE id = $producto_id";
    if ($conn->query($sql_descuento) === TRUE) {
        echo "Se ha descontado la cantidad de productos del inventario";
    } else {
        echo "Error al descontar la cantidad de productos del inventario: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
