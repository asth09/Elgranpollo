<?php
session_start();
if ( !isset($_SESSION['usuario']) ) {
    header("location: index.php"); 
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Despacho</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="shortcut icon" href="LOGO EL GRAN POLLO.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='styles.css'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
    <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
</head>
<body>
<div class="contenedor-header">
        <header>
            <div class="logo">
                <a href="home.php"><img src="LOGO EL GRAN POLLO.png" alt="2x2" width="60" heigth="60"></a>
            </div>
            <nav id="nav" class="">
                <ul>
                    <li><a href="home.php" onclick="seleccionar()">INICIO</a></li>
                    <li><a href="clientes.php" onclick="seleccionar()">CLIENTES</a></li>
                    <li><a href="productos.php" onclick="seleccionar()">PRODUCTOS</a></li>
                    <li><a href="entradas_aux.php" onclick="seleccionar()">ENTRADAS AUX</a></li>
                    <li><a href="salidas_aux.php" onclick="seleccionar()">SALIDAS AUX</a></li>
                    <li><a href="pedidos.php" onclick="seleccionar()">PEDIDOS</a></li>
                    <li><a href="despacho.php" onclick="seleccionar()">DESPACHO</a></li>
                    <li><a href="controlador_cerrar_session.php" onclick="seleccionar()">SALIR</a></li>
                </ul>
            </nav>
            <div class="nav-responsive" onclick="mostrarOcultarMenu()">
              <i class="fa fa-bars"></i>
            </div>
        </header>
    </div>
    <br>
    <br>
    <br>
        <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left" id="despacho">Despacho</h2>
                        <a href="pedidos.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                    <div class="container-fluid">
                    <form class="d-flex">
                    <input class="form-control me-2 light-table-filter" data-table="table_id" type="text" 
                    placeholder="Buscar:">
                    <hr>
                   </form>
                  </div>
                  <br>

                    <!-- Copiar desde aqui -->
                    <?php

                    // Incluir configuracion de la Base de Datos
                    require_once "conexion_bd2.php";

                    $esAdmin = isset($_SESSION['es_admin']) && $_SESSION['es_admin'];
                    
                    $sql = $esAdmin ? "SELECT ventas.id, ventas.fecha, ventas.total, usuarios.usuario AS nombre_usuario, clientes.nombre AS nombre_cliente FROM ventas JOIN usuarios ON ventas.id_usuario = usuarios.id JOIN clientes ON ventas.id_cliente = clientes.id ORDER BY ventas.id DESC" : "SELECT ventas.id, ventas.fecha, ventas.total, usuarios.usuario AS nombre_usuario, clientes.nombre AS nombre_cliente FROM ventas JOIN usuarios ON ventas.id_usuario = usuarios.id JOIN clientes ON ventas.id_cliente = clientes.id WHERE ventas.id_usuario = ".$_SESSION['id_usuario']." ORDER BY ventas.id DESC";
                    if ($result = mysqli_query($conexion, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped table_id">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Id</th>";
                            echo "<th>Fecha</th>";
                            echo "<th>Total</th>";
                            echo "<th>Vendedor</th>";
                            echo "<th>Cliente</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fecha'] . "</td>";
                                echo "<td>" . $row['total'] . "</td>";
                                echo "<td>" . $row['nombre_usuario'] . "</td>";
                                echo "<td>" . $row['nombre_cliente'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_despacho.php?id='. $row['id'] .'" class="mr-3" title="Ver registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_despacho.php?id='. $row['id'] .'" class="mr-3" title="Modificar registro" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            
                                        echo "</td>";
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

                    // Cerrar coneccion
                    mysqli_close($conexion);
                    ?>
                    <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                     <li class="page-item disabled">
                     <a class="page-link">Anterior</a>
                     </li>
                     <li class="page-item"><a class="page-link" href="#">1</a></li>
                     <li class="page-item"><a class="page-link" href="#">2</a></li>
                     <li class="page-item"><a class="page-link" href="#">3</a></li>
                     <li class="page-item">
                     <a class="page-link" href="#">Siguiente</a>
                    </li>
                 </ul>
                </nav>
</body>
</html>