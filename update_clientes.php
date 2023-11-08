<?php
require_once "conexion_bd.php";
 
$nombre = "";
$rif = "";
$direccion = "";
$telefono = "";
$vendedor = "";

 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $id = $_POST["id"];
    
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


    $sql = "UPDATE clientes SET nombre=?, rif=?, direccion=?, telefono=?, vendedor=?
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
        mysqli_stmt_bind_param($stmt, "ssssss", $param_nombre, $param_rif, $param_direccion, $param_telefono, 
                                              $param_vendedor, $param_id);

        $param_nombre = $nombre;
        $param_rif = $rif;
        $param_direccion = $direccion;
        $param_telefono = $telefono;
        $param_vendedor = $vendedor;
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
        
        $sql = "SELECT * FROM clientes WHERE id = ?";
        if($stmt = mysqli_prepare($conexion, $sql)){

            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
            
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $nombre = $row["nombre"];
                    $rif = $row["rif"];
                    $direccion = $row["direccion"];
                    $telefono = $row["telefono"];
                    $vendedor = $row["vendedor"];
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
                            <label>Nombre cliente</label>
                            <br>
                            <input type="text" name="nombre" value="<?php echo $nombre; ?>">
                        </div>

                        <div class="form-group">
                            <label>Rif</label>
                            <br>
                            <input type="text" name="rif" value="<?php echo $rif; ?>">
                        </div>

                        <div class="form-group">
                            <label>Direccion</label>
                            <br>
                            <input type="text" name="direccion" value="<?php echo $direccion; ?>">
                        </div>

                        <div class="form-group">
                            <label>Telefono</label>
                            <br>
                            <input type="text" name="telefono" value="<?php echo $telefono; ?>">
                        </div>

                        <div class="form-group">
                            <label>Vendedor</label>
                            <br>
                            <input type="text" name="vendedor" value="<?php echo $vendedor; ?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

