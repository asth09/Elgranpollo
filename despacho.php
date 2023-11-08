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
                    <li><a href="home.php #inicio" onclick="seleccionar()">INICIO</a></li>
                    <li><a href="home.php #clientes" onclick="seleccionar()">CLIENTES</a></li>
                    <li><a href="home.php #productos" onclick="seleccionar()">PRODUCTOS</a></li>
                    <li><a href="pedidos.php" onclick="seleccionar()">PEDIDOS</a></li>
                    <li><a href="despacho.php" onclick="seleccionar()">DESPACHO</a></li>
                    <li><a href="controlador_cerrar_session.php" onclick="seleccionar()">SALIR</a></li>
                </ul>
            </nav>
            <div class="nav-responsive" onclick="mostrarOcultarMenu()">
                <i class="fa-solid fa-bars"></i>
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
                        <a href="create_despacho.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Agregar un despacho</a>
                    </div>

                    <!-- Copiar desde aqui -->
                    <?php

                    // Incluir configuracion de la Base de Datos
                    require_once "conexion_bd.php";
                    
                    $sql = "SELECT * FROM despacho";
                    if($result = mysqli_query($conexion, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>id</th>";
                                        echo "<th>codigo_prod</th>";
                                        echo "<th>cantidad</th>";
                                        echo "<th>precio</th>";
                                        echo "<th>estado</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['codigo_prod'] . "</td>";
                                        echo "<td>" . $row['cantidad'] . "</td>";
                                        echo "<td>" . $row['precio'] . "</td>";
                                        echo "<td>" . $row['estado'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_despacho.php?id='. $row['id'] .'" class="mr-3" title="Ver registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_despacho.php?id='. $row['id'] .'" class="mr-3" title="Modificar registro" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete_despacho.php?id='. $row['id'] .'" title="Borrar registro" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
</body>
</html>