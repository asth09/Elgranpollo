<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="shortcut icon" href="LOGO EL GRAN POLLO.png" />
    <link rel='stylesheet' type='text/css' media='screen' href='estilos.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
</head>
    <body>
    <section class="form-main">
        <div class="form-conte">
            <div class="box">
                <h1>Login</h1>
                <form action="validar.php" method="post">
                    <p>Usuario
                        <input type="text" placeholder="Ingrese su usuario" name="usuario" >
                        
                    </p>
                    <p>Contraseña
                        <input type="password" placeholder="Ingrese su Contraseña" name="password" >
                        
                    </p>
                    <button  type="submit" class="btn">Ingresar</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>