<?php
session_start();
if ( !isset($_SESSION['usuario']) ) {
    header("location: index.php"); 
    die();
}
?>
<?php
require_once "conexion_bd.php";
 
$codigo_prod = "";
$cantidad = "";
$precio = "";
$estado = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $id = $_POST["id"];
    
    $input_codigo_prod = trim($_POST["codigo_prod"]);
    $codigo_prod = $input_codigo_prod;
        
    $input_cantidad = trim($_POST["cantidad"]);
    $cantidad = $input_cantidad;
        
    $input_precio = trim($_POST["precio"]);
    $precio = $input_precio;
    
    $input_estado = trim($_POST["estado"]);
    $estado = $input_estado;

    $sql = "UPDATE despacho SET codigo_prod=?, cantidad=?,
                                precio=?, estado=?
            WHERE id=?";
        
    if($stmt = mysqli_prepare($conexion, $sql)){

        /*   **** ATENCION ***
        el parametro "issd" de la siguiente funcion, significan los tipos
        de datos de las variables enviadas como parametros:
        i para tipo INTEGER
        s para STRING
        d para DECIMAL
        segun el orden en que se declaran en la funcion
        */
        mysqli_stmt_bind_param($stmt, "issdi", $param_codigo_prod, $param_cantidad, 
        $param_precio, $param_estado, $param_id);

        $param_codigo_prod = $codigo_prod;
        $param_cantidad = $cantidad;
        $param_precio = $precio;
        $param_estado = $estado;
        $param_id = $id;

        if(mysqli_stmt_execute($stmt)){
            header("location: despacho.php");
            exit();
        } else{
            echo "ERROR..";
        }
    }
        
    mysqli_stmt_close($stmt);
    
    mysqli_close($conexion);

} else{

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM despacho WHERE id = ?";
        if($stmt = mysqli_prepare($conexion, $sql)){

            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
            
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $codigo_prod = $row["codigo_prod"];
                    $cantidad = $row["cantidad"];
                    $precio = $row["precio"];
                    $estado = $row["estado"];
                } else{
                    echo "ERROR..";
                }
                
            } else{
                echo "ERROR..";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($conexion);
    }  else{
        echo "ERROR..";
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modificar registro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="shortcut icon" href="LOGO EL GRAN POLLO.png" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='styles.css'>
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
                    <h2 class="mt-5">Modificar registro</h2>
                    <p>Procure ingresar datos correctos. No se validan los datos</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                            <label>Codigo del producto</label>
                            <br>
                            <input type="text" name="codigo_prod" value="<?php echo $codigo_prod; ?>">
                        </div>

                        <div class="form-group">
                            <label>Cantidad</label>
                            <br>
                            <input type="text" name="cantidad" value="<?php echo $cantidad; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Precio</label>
                            <br>
                            <input type="text" name="precio" value="<?php echo $precio; ?>">
                        </div>
                                                
                        <div class="form-group">
                            <label>Estado</label>
                            <br>
                            <input type="text" name="estado" value="<?php echo $estado; ?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="despacho.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

