<?php
require_once "conexion_bd.php";
 
$nombre = "";
$existencia = "";
$clasificacion = "";
$costo = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $id = $_POST["id"];
    
    $input_nombre = trim($_POST["nombre"]);
    $nombre = $input_nombre;
        
    $input_existencia = trim($_POST["existencia"]);
    $existencia = $input_existencia;
        
    $input_clasificacion = trim($_POST["clasificacion"]);
    $clasificacion = $input_clasificacion;
    
    $input_costo = trim($_POST["costo"]);
    $costo = $input_costo;

    $sql = "UPDATE producto SET nombre=?, existencia=?,
                                clasificacion=?, costo=?
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
        mysqli_stmt_bind_param($stmt, "ssssi", $param_nombre, $param_existencia, 
        $param_clasificacion, $param_costo, $param_id);

        $param_nombre = $nombre;
        $param_existencia = $existencia;
        $param_clasificacion = $clasificacion;
        $param_costo = $costo;
        $param_id = $id;

        if(mysqli_stmt_execute($stmt)){
            header("location: home.php");
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
        
        $sql = "SELECT * FROM producto WHERE id = ?";
        if($stmt = mysqli_prepare($conexion, $sql)){

            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
            
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $nombre = $row["nombre"];
                    $existencia = $row["existencia"];
                    $clasificacion = $row["clasificacion"];
                    $costo = $row["costo"];
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
                            <label>Nombre del producto</label>
                            <br>
                            <input type="text" name="nombre" value="<?php echo $nombre; ?>">
                        </div>

                        <div class="form-group">
                            <label>Existencia</label>
                            <br>
                            <input type="text" name="existencia" value="<?php echo $existencia; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Clasificacion</label>
                            <br>
                            <input type="text" name="clasificacion" value="<?php echo $clasificacion; ?>">
                        </div>
                                                
                        <div class="form-group">
                            <label>Costo</label>
                            <br>
                            <input type="text" name="costo" value="<?php echo $costo; ?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="home.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

