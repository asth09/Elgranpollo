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
    <meta charset="UTF-8">
    <title>Crear registro</title>
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
                            <label>Nombre</label>
                            <br>
                            <input type="text" name="nombre">
                        </div>

                        <div class="form-group">
                            <label>Rif</label>
                            <br>
                            <input type="text" name="rif">
                        </div>

                        <div class="form-group">
                            <label>Direccion</label>
                            <br>
                            <input type="text" name="direccion">
                        </div>

                        <div class="form-group">
                            <label>Telefono</label>
                            <br>
                            <input type="text" name="telefono">
                        </div>

                        <div class="form-group">
                            <label>Vendedor</label>
                            <br>
                            <input type="text" name="vendedor">
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
