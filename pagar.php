<?php
// Aquí iría la conexión a la base de datos
require_once "conexion_bd.php";
// Obtener la información de la factura
$id_factura = $_POST['id_factura']; // Suponiendo que obtienes el id de la factura desde algún lugar
$monto_total = // Obtener el monto total de la factura desde la base de datos

// Obtener el monto abonado hasta el momento
$query = "SELECT SUM(monto_abonado) AS total_abonado FROM pagos WHERE id_factura = $id_factura";
$result = // Ejecutar la consulta y obtener el resultado

$total_abonado = $_POST['total_abonado']; // Obtener el monto abonado desde el resultado de la consulta

// Mostrar el formulario para abonar
echo "Monto total: $monto_total<br>";
echo "Monto abonado: $total_abonado<br>";

if ($total_abonado < $monto_total) {
    echo "<form action='procesar_pago.php' method='post'>";
    echo "<input type='hidden' name='id_factura' value='$id_factura'>";
    echo "Monto a abonar: <input type='number' name='monto_abonar' max='" . ($monto_total - $total_abonado) . "'><br>";
    echo "<input type='submit' value='Abonar'>";
    echo "</form>";
} else {
    echo "Esta factura ya ha sido cancelada en su totalidad.";
}
?>
