<?php

require_once "conexion_bd.php";

$nombre = "";
$existencia = "";
$clasificacion = "";
$costo = "";

// Se ejecuta el metodo del formulario
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $input_nombre = trim($_POST["nombre"]);
    $nombre = $input_nombre;
        
    $input_existencia = trim($_POST["existencia"]);
    $existencia = $input_existencia;
        
    $input_clasificacion = trim($_POST["clasificacion"]);
    $clasificacion = $input_clasificacion;
    
    $input_costo = trim($_POST["costo"]);
    $costo = $input_costo;
    
    $sql = "INSERT INTO producto (nombre, existencia, clasificacion, costo) 
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
        mysqli_stmt_bind_param($stmt, "ssss", $param_nombre, $param_existencia, 
                                                $param_clasificacion, $param_costo);
        
        $param_nombre = $nombre;
        $param_existencia = $existencia;
        $param_clasificacion = $clasificacion;
        $param_costo = $costo;

        if(mysqli_stmt_execute($stmt)){ //Se manda a ejecutar el comando SQL
            header("location: home.php");
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
                            <label>Nombre del producto</label>
                            <br>
                            <input type="text" name="nombre">
                        </div>

                        <div class="form-group">
                            <label>Existencia</label>
                            <br>
                            <input type="text" name="existencia">
                        </div>
                        
                        <div class="form-group">
                            <label>Clasificacion</label>
                            <br>
                            <input type="text" name="clasificacion">
                        </div>
                                                
                        <div class="form-group">
                            <label>Costo</label>
                            <br>
                            <input type="text" name="costo">
                        </div>

                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="home.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>
