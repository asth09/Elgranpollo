<?php
session_start();
if ( !isset($_SESSION['usuario']) ) {
    header("location: index.php"); 
    die();
}
?>
<?php

require_once "conexion_bd.php";

$nombre = "";
$rif = "";
$direccion = "";
$telefono = "";
$vendedor = "";


// Se ejecuta el metodo del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $input_nombre = trim($_POST["nombre"]);
    $nombre = $input_nombre;
        
    $input_rif = trim($_POST["rif"]);
    $rif = $input_rif;

    $input_direccion = trim($_POST["direccion"]);
    $direccion = $input_direccion;

    $input_telefono = trim($_POST["telefono"]);
    $telefono = $input_telefono;

    $input_vendedor = trim($_POST["vendedor"]);
    $vendedor = $input_vendedor;
    
    $sql = "INSERT INTO clientes (nombre, rif, direccion, telefono, vendedor) 
            VALUES (?, ?, ?, ?, ?)";
            /* Notese que los valores se colocan como signos ?
                estos es porque seran sustituidos por los valores de las 
                variables leidas en el formulario */
    
    if($stmt = mysqli_prepare($conexion, $sql)){
        
        /*   **** ATENCION ***
        el parametro "issd" de la siguiente funcion, significan los tipos
        de datos de las variables enviadas como parametros:
        i para tipo INTEGER
        s para STRING
        d para DECIMAL
        segun el orden en que se declaran en la funcion
        */
        mysqli_stmt_bind_param($stmt, "sssss", $param_nombre, $param_rif, $param_direccion,
                                             $param_telefono, $param_vendedor);
        
        $param_nombre = $nombre;
        $param_rif = $rif;
        $param_direccion = $direccion;
        $param_telefono = $telefono;
        $param_vendedor = $vendedor;

        if(mysqli_stmt_execute($stmt)){ //Se manda a ejecutar el comando SQL
            header("location: clientes.php");
            exit();
        } else{
            echo "ERROR..";
        }
    }
        
    mysqli_stmt_close($stmt);
    
    mysqli_close($conexion);
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
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
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
                    <h2 class="mt-5">Crear registro</h2>
                    <p>Procure ingresar datos correctos. No se validan los datos</p>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nombre</label>
                            <br>
                            <input type="text" name="nombre">
                        </div>

                        <div class="form-group">
                            <label>Rif</label>
                            <br>
                            <input type="number" maxlength="9" name="rif">
                        </div>

                        <div class="form-group">
                            <label>Direccion</label>
                            <br>
                            <input type="text" name="direccion">
                        </div>

                        <div class="form-group">
                            <label>Telefono</label>
                            <br>
                            <input maxlength="11" type="number" name="telefono">
                        </div>
                          
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
                        <div> 
                          <label>Vendedor</label> 
                          <br>
                         <select name="vendedor">
                         <?php
                         $usuario_query = "SELECT id, usuario FROM usuarios";
                         $usuario_result = $conn->query($usuario_query);
                         while($row = $usuario_result->fetch_assoc()) {
                            echo "<option value='" . $row['usuario'] . "'>" . $row['usuario'] . "</option>";
                         }
                         ?>
                         </select>
                        </div> 
                        <br>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="clientes.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>
