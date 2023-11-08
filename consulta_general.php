<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
    <title>Consulta general</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Consulta General</h2>
                    </div>

                    <?php

                    // Incluir configuracion de la Base de Datos
                    require_once "conexion_bd.php";
                    
                    // ATENCION: Observe que se usan alias para algunos campos
                    $sql = "SELECT clientes.nombre AS clientes, producto.nombre AS producto, clientes.rif tipo, producto.costo FROM producto JOIN clientes on (producto.existencia = clientes.id AND producto.costo > 30000 AND clientes.direccion LIKE 'pasta y derivados') ORDER BY marca.detalle_marca;";

                    if($result = mysqli_query($conexion, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Marcas</th>";
                                        echo "<th>Tipo de producto</th>";
                                        echo "<th>Clase de marca</th>";
                                        echo "<th>Costo</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        // Fijense que se usan los nombres de los campos y/o los alias 
                                        echo "<td>" . $row['marca'] . "</td>";
                                        echo "<td>" . $row['producto'] . "</td>";
                                        echo "<td>" . $row['tipo'] . "</td>";
                                        echo "<td>" . $row['costo'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";

                            mysqli_free_result($result);

                        } else{
                            echo '<div class="alert alert-danger"><em>Ningun registro encontrado.</em></div>';
                        }
                    } else{
                        echo "Oops! ERROR.. Intente mas tarde";
                    }
 
                    // Cerrar conexcion
                    mysqli_close($conexion);
                    ?>

                </div>
                <p><a href="index.php" class="btn btn-primary">Regresar</a></p>
                
            </div>       

        </div>
    </div>

</body>
if((!isset($USUARIO=$_POST['usuario']) || $USUARIO=$_POST['usuario']=="")  || (!isset
($password=$_POST['password']) || $password=$_POST['password']=="")){
    session_destroy();
    if(headers_sent()){
        echo "<script> window.location.href='index.php?
        vista=login'; </script>";
    }else{
        header("location: index.php?vista=login");
    }
    <?php
session_start();
include 'conexion_bd.php';

$usuario = $_session['usuario'];
if(!isset($usuario)){
    header("location:index.php");
}
?>

<?php
session_start();
if (empty($_SESSION["usuario"])){
    header("location:index.php");
}
?>
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location:index.php");
}
session_start();
if ( !isset($_SESSION['usuario']) ) {
    header("location: index.php"); 
    die();
}
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
</html>


