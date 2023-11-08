<?php

require_once "conexion_bd.php";

$codigo_prod = "";
$cantidad = "";
$precio = "";
$estado = "";

// Se ejecuta el metodo del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $input_codigo_prod = trim($_POST["codigo_prod"]);
    $codigo_prod = $input_codigo_prod;
        
    $input_cantidad = trim($_POST["cantidad"]);
    $cantidad = $input_cantidad;
        
    $input_precio = trim($_POST["precio"]);
    $precio = $input_precio;
    
    $input_estado = trim($_POST["estado"]);
    $estado = $input_estado;
    
    $sql = "INSERT INTO despacho (codigo_prod, cantidad, precio, estado) 
            VALUES (?, ?, ?, ?)";
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
        mysqli_stmt_bind_param($stmt, "ssss", $param_codigo_prod, $param_cantidad, 
                                                $param_precio, $param_estado);
        
        $param_codigo_prod = $codigo_prod;
        $param_cantidad = $cantidad;
        $param_precio = $precio;
        $param_estado = $estado;

        if(mysqli_stmt_execute($stmt)){ //Se manda a ejecutar el comando SQL
            header("location: despacho.php");
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
                            <label>Codigo del producto</label>
                            <br>
                            <input type="text" name="codigo_prod">
                        </div>

                        <div class="form-group">
                            <label>Cantidad</label>
                            <br>
                            <input type="text" name="cantidad">
                        </div>
                        
                        <div class="form-group">
                            <label>Precio</label>
                            <br>
                            <input type="text" name="precio">
                        </div>
                                                
                        <div class="form-group">
                            <label>Estado</label>
                            <br>
                            <input type="text" name="estado">
                        </div>

                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="despacho.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>