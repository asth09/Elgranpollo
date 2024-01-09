<?php
// Aquí iría la conexión a la base de datos
require_once "conexion_bd.php";
// Obtener los datos del formulario
$id_factura = $_POST['id_factura'];
$monto_abonar = $_POST['monto_abonar'];

// Insertar el pago en la tabla de pagos
$query = "INSERT INTO pagos (id_factura, monto_abonado, fecha_abono) VALUES ($id_factura, $monto_abonar, NOW())";
// Ejecutar la consulta para insertar el pago

// Actualizar el monto abonado en la factura
$query = "UPDATE facturas SET monto_abonado = monto_abonado + $monto_abonar WHERE id_factura = $id_factura";
// Ejecutar la consulta para actualizar el monto abonado en la factura

// Verificar si el monto abonado es igual al monto total y actualizar el estado de la factura si corresponde
$query = "SELECT monto_total, SUM(monto_abonado) AS total_abonado FROM facturas WHERE id_factura = $id_factura";
$result = // Ejecutar la consulta y obtener el resultado

$row = // Obtener el resultado como un array asociativo

if ($row['monto_total'] == $row['total_abonado']) {
    $query = "UPDATE facturas SET estado = 'cancelado' WHERE id_factura = $id_factura";
    // Ejecutar la consulta para actualizar el estado de la factura
}

// Redirigir a una página de confirmación o mostrar un mensaje de éxito
echo "El pago se ha procesado correctamente.";
?>
