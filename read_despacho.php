<?php

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    
    require_once "conexion_bd.php";
    
    $sql = "SELECT * FROM despacho WHERE id = ?";
    
    if($stmt = mysqli_prepare($conexion, $sql)){

        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        $param_id = trim($_GET["id"]);
        
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
} else{
    echo "ERROR..";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultar registro</title>
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
                    <h1 class="mt-5 mb-3">Consultar registro</h1>
                    <p>Codigo del Producto: <b><?php echo $codigo_prod; ?></b></p>
                    <p>Cantidad: <b><?php echo $cantidad; ?></b></p>
                    <p>Precio: <b><?php echo $precio; ?></b></p>
                    <p>Estado: <b><?php echo $estado; ?></b></p>
                    <p><a href="despacho.php" class="btn btn-primary">Regresar</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

