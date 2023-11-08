<?php

require_once "conexion_bd.php";

$id_cliente = "";
$fecha = "";
$total_precio = "";

// Se ejecuta el metodo del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $input_id_cliente = trim($_POST["id_cliente"]);
    $id_cliente = $input_id_cliente;
        
    $input_fecha = trim($_POST["fecha"]);
    $fecha = $input_fecha;
        
    $input_total_precio = trim($_POST["total_precio"]);
    $total_precio = $input_total_precio;
    
    $sql = "INSERT INTO pedidos (id_cliente, fecha, total_precio) 
            VALUES (?, ?, ?)";
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
        mysqli_stmt_bind_param($stmt, "sss", $param_id_cliente, $param_fecha, 
                                                $param_total_precio);
        
        $param_id_cliente = $id_cliente;
        $param_fecha = $fecha;
        $param_total_precio = $total_precio;

        if(mysqli_stmt_execute($stmt)){ //Se manda a ejecutar el comando SQL
            header("location: pedidos.php");
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
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta charset="UTF-8">
    <title>Crear registro</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
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
                    <h2 class="mt-5">Crear registro</h2>
                    <p>Procure ingresar datos correctos. No se validan los datos</p>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Id del cliente</label>
                            <br>
                            <input type="text" name="id_cliente">
                        </div>

                        <div class="form-group">
                            <label>Fecha</label>
                            <br>
                            <input type="text" name="fecha">
                        </div>
                        
                        <div class="form-group">
                            <label>Total Precio</label>
                            <br>
                            <input type="text" name="total_precio">
                        </div>

                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="pedidos.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>
