<?php
session_start();
if ( !isset($_SESSION['usuario']) ) {
    header("location: index.php"); 
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Crear registro</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="shortcut icon" href="LOGO EL GRAN POLLO.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='styles.css'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='main.js'></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="contenedor-header">
        <header>
            <div class="logo">
             <a href="home.php"><img src="LOGO EL GRAN POLLO.png" alt="2x2" width="60" heigth="60"></a>
            </div>
            <nav id="nav" class="">
                <ul>
                    <li><a href="clientes.php" onclick="seleccionar()">CLIENTES</a></li>
                    <li><a href="productos.php" onclick="seleccionar()">PRODUCTOS</a></li>
                    <li><a href="proveedor.php" onclick="seleccionar()">PROVEEDOR</a></li>
                    <li><a href="entradas_aux.php" onclick="seleccionar()">ENTRADAS AUX</a></li>
                    <li><a href="salidas_aux.php" onclick="seleccionar()">SALIDAS AUX</a></li>
                    <li><a href="pedidos.php" onclick="seleccionar()">VENTAS</a></li>
                    <li><a href="comprar.php" onclick="seleccionar()">COMPRAR</a></li>
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
                    <h2 class="mt-5">Crear una entrada</h2>
                    <p>Procure ingresar datos correctos. No se validan los datos</p>
                    

                    <?php
	                     // Conexión a la base de datos
                         $servername = "localhost";
                         $username = "root";
                         $password = "";
                         $dbname = "registro";

                         $conn = new mysqli($servername, $username, $password, $dbname);

                         if ($conn->connect_error) {
                         die("Conexión fallida: " . $conn->connect_error);
                         }
                        ?> 
                        
     <form action="procesar_entrada.php" method="POST" enctype="multipart/form-data">
           <!-- Campo select para id_cliente -->
                    <div> 
                          <label>Seleccione el producto</label> 
                          <br>
                         <select name="id_producto" class="form-group">
                         <?php
                         $producto_query = "SELECT id, nombre FROM producto";
                         $producto_result = $conn->query($producto_query);
                         while($row = $producto_result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                         }
                         ?>
                         </select>
                        </div> 
                        <div class="form-group">
                            <label>Cantidad a ingresar</label>
                            <br>
                            <input type="number" name="entradas">
                        </div>
                                                
                        <div class="form-group">
                            <label>Observacion</label>
                            <br>
                            <input type="text" name="observacion">
                        </div>
                    

                <!-- Campo oculto para id_usuario -->
             <input name="id_usuario" type="hidden" value="<?php echo $_SESSION['id_usuario']; ?>">

             <button type="submit" class="btn btn-primary" name="enviar">Aceptar</button>
             <a href="entradas_aux.php" class="btn btn-danger">Cancelar</a>
    </form>
</body>
</html>
