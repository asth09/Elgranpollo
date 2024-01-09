<?php 
session_start(); 
 
// Validaciones 

$id_usuario = isset($_SESSION["id_usuario"]) ? intval($_SESSION["id_usuario"]) : exit("Usuario no logueado");
// Suponiendo que estas variables deberían provenir de algún formulario o alguna otra fuente de datos
if(isset($_POST['enviar'])){


$id_producto = $_POST['id_producto']; // Cambia 'id_producto' por el id_producto correcto del campo
$salidas = $_POST['salidas']; // Cambia 'entradas' por el id_producto correcto del campo
$observacion = $_POST['observacion']; // Cambia 'observacion' por el id_producto correcto del campo

// Luego de recibir los valores, puedes verificar si están definidos y no son nulos
if(isset($id_producto) && isset($salidas) && isset($observacion)) {
    // Tu código para la inserción en la base de datos aquí
} else {
    exit("Ocurrió un error: Algunos datos no fueron proporcionados"); // Manejo de errores si los datos no están presentes
}

 
 
include_once "base_de_datos.php"; 
 
// Aquí asumimos que ya has iniciado la sesión y verificado que el usuario está logueado 
date_default_timezone_set("America/Caracas");
$ahora = date("Y-m-d H:i:s"); 
 
try { 
    $base_de_datos->beginTransaction(); 
 
    $sentencia = $base_de_datos->prepare("INSERT INTO salidas(id_producto, salidas, observacion, id_usuario, fecha) VALUES (?, ?, ?, ?, ?);"); 
    $sentencia->execute([$id_producto, $salidas, $observacion, $id_usuario, $ahora]); 
 
    $sentencia = $base_de_datos->prepare("SELECT id FROM salidas ORDER BY id DESC LIMIT 1;"); 
    $sentencia->execute(); 
    $resultado = $sentencia->fetch(PDO::FETCH_OBJ); 
 
     
 
    $sentencia = $base_de_datos->prepare("INSERT INTO producto(existencia) VALUES (?);"); 
    $sentenciaExistencia = $base_de_datos->prepare("UPDATE producto SET existencia = existencia - ? WHERE id = ?;"); 
 
    
        // Asegúrate de que 'total' y 'cantidad' son valores numéricos válidos 
        $sentencia->execute([$id_producto, $salidas]); 
        $sentenciaExistencia->execute([$salidas, $id_producto]); 
    
 
    $base_de_datos->commit(); 
} catch (Exception $e) { 
    $base_de_datos->rollBack(); 
    exit("Ocurrió un error: " . $e->getMessage()); 
} 
 
unset($_SESSION["carrito"]); 
$_SESSION["carrito"] = []; 
header("Location: salidas_aux.php"); 
}