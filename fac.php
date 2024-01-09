<?php
session_start();
if ( !isset($_SESSION['usuario']) ) {
    header("location: index.php"); 
    die();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Pedidos</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="shortcut icon" href="LOGO EL GRAN POLLO.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' type='text/css' media='screen' href='styles.css'>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
    <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
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
    <br>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left" id="clientes">Pedidos</h2>
                        <a href="despacho2.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Ver el despacho</a>
                    </div>
                    <div class="container-fluid">
                    <form class="d-flex" method="post" action="agregar.php">
		            <input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
                    <hr>
                   </form>
                  </div>
                  <br>
                  <?php

if (!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
$granTotal = 0;
?>
<div class="col-xs-12">
	<?php
	if (isset($_GET["status"])) {
		if ($_GET["status"] === "1") {
	?>
			<div class="alert alert-success">
				<strong>¡Correcto!</strong> Pedido realizado correctamente
			</div>
		<?php
		} else if ($_GET["status"] === "2") {
		?>
			<div class="alert alert-info">
				<strong>Pedido cancelado</strong>
			</div>
		<?php
		} else if ($_GET["status"] === "3") {
		?>
			<div class="alert alert-info">
				<strong>Ok</strong> Producto quitado de la lista
			</div>
		<?php
		} else if ($_GET["status"] === "4") {
		?>
			<div class="alert alert-warning">
				<strong>Error:</strong> El producto que buscas no existe
			</div>
		<?php
		} else if ($_GET["status"] === "5") {
		?>
			<div class="alert alert-danger">
				<strong>Error: </strong>El producto está agotado
			</div>
		<?php
		} else {
		?>
			<div class="alert alert-danger">
				<strong>Error:</strong> Algo salió mal mientras se realizaba el pedido
			</div>
	<?php
		}
	}
	?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Total</th>
				<th>Quitar</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($_SESSION["carrito"] as $indice => $producto) {
				$granTotal += $producto->total;
			?>
				<tr>
					<td><?php echo $producto->id ?></td>
					<td><?php echo $producto->codigo ?></td>
					<td><?php echo $producto->nombre ?></td>
					<td><?php echo $producto->precio ?></td>
					<td>
						<form action="cambiar_cantidad.php" method="post">
							<input name="indice" type="hidden" value="<?php echo $indice; ?>">
							<input min="1" name="cantidad" class="form-control" required type="number" step="0.1" value="<?php echo $producto->cantidad; ?>">
						</form>
					</td>
					<td><?php echo $producto->total ?></td>
					<td><a class="btn btn-danger" href="<?php echo "quitarDelCarrito.php?indice=" . $indice ?>"><i class="fa fa-trash"></i></a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
    <h3>Total: <?php echo $granTotal; ?></h3>
	<?php
	// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registro2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}
?>
     <form action="terminarPedido.php" method="POST">
    <!-- Campo select para id_cliente -->
    <select name="id_cliente" class="form-control">
        <?php
		 // Comprobar si el usuario es el administrador
		 $esAdmin = isset($_SESSION['es_admin']) && $_SESSION['es_admin'];
                    
		 // Si el usuario es admin, mostrar todos los clientes. De lo contrario, solo los asignados a él.
		$sql = $esAdmin ? "SELECT * FROM clientes" : "SELECT * FROM clientes WHERE vendedor = '" . $_SESSION['usuario'] . "'";

        $clientes_result = $conn->query($sql);
        while($row = $clientes_result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
        }
        ?>
    </select>

    <!-- Campo oculto para id_usuario -->
    <input name="id_usuario" type="hidden" value="<?php echo $_SESSION['id_usuario']; ?>">

    <input name="total" type="hidden" value="<?php echo $granTotal; ?>">
    <button type="submit" class="btn btn-success">Terminar pedido</button>
    <a href="./cancelarVenta.php" class="btn btn-danger">Cancelar venta</a>
</form>
</form>
</div> 
</body>
</html>