<?php
require_once "conexion_bd.php";
 
$id_cliente = "";
$fecha = "";
$total_precio = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $id = $_POST["id"];
    
    $input_id_cliente = trim($_POST["id_cliente"]);
    $id_cliente = $input_id_cliente;
        
    $input_fecha = trim($_POST["fecha"]);
    $fecha = $input_fecha;
        
    $input_total_precio = trim($_POST["total_precio"]);
    $total_precio = $input_total_precio;
    

    $sql = "UPDATE pedidos SET id_cliente=?,
                                fecha=?, total_precio=?
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
        mysqli_stmt_bind_param($stmt, "sssi", $param_id_cliente, $param_fecha, 
        $param_total_precio, $param_id);

        $param_id_cliente = $id_cliente;
        $param_fecha = $fecha;
        $param_total_precio = $total_precio;
        $param_id = $id;

        if(mysqli_stmt_execute($stmt)){
            header("location: pedidos.php");
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
        
        $sql = "SELECT * FROM pedidos WHERE id = ?";
        if($stmt = mysqli_prepare($conexion, $sql)){

            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
            
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $id_cliente = $row["id_cliente"];
                    $fecha = $row["fecha"];
                    $total_precio = $row["total_precio"];
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
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Modificar registro</h2>
                    <p>Procure ingresar datos correctos. No se validan los datos</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                            <label>Id del cliente</label>
                            <br>
                            <input type="text" name="id_cliente" value="<?php echo $id_cliente; ?>">
                        </div>

                        <div class="form-group">
                            <label>Fecha</label>
                            <br>
                            <input type="text" name="fecha" value="<?php echo $fecha; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Total Precio</label>
                            <br>
                            <input type="text" name="total_precio" value="<?php echo $total_precio; ?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="pedidos.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

