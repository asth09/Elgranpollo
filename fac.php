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
                    <li><a href="home.php" onclick="seleccionar()">INICIO</a></li>
                    <li><a href="clientes.php" onclick="seleccionar()">CLIENTES</a></li>
                    <li><a href="productos.php" onclick="seleccionar()">PRODUCTOS</a></li>
					<li><a href="#pedidos" onclick="seleccionar()">VENTAS</a></li>
                    <li><a href="fac.php" onclick="seleccionar()">PEDIDOS</a></li>
                    <li><a href="despacho.php" onclick="seleccionar()">DESPACHO</a></li>
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
    <?php

if (!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
$granTotal = 0;
?>
<div class="col-xs-12">
	<h1>Pedido</h1>
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
	<form method="post" action="agregar.php">
		<label for="codigo">Código del producto:</label>
		<input autocomplete="off" autofocus class="form-control" name="codigo" required type="text" id="codigo" placeholder="Escribe el código">
	</form>
	<br><br>
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

<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left" id="despacho">Despacho</h2>
                        <a href="pedidos.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                    <div class="container-fluid">
                    <form class="d-flex">
                    <input class="form-control me-2 light-table-filter" data-table="table_id" type="text" 
                    placeholder="Buscar:">
                    <hr>
                   </form>
                  </div>
                  <br>

                    <!-- Copiar desde aqui -->
                    <?php

                    // Incluir configuracion de la Base de Datos
                    require_once "conexion_bd2.php";

                    $esAdmin = isset($_SESSION['es_admin']) && $_SESSION['es_admin'];
                    
                    $sql = $esAdmin ? "SELECT ventas.id, ventas.fecha, ventas.total, usuarios.usuario AS nombre_usuario, clientes.nombre AS nombre_cliente FROM ventas JOIN usuarios ON ventas.id_usuario = usuarios.id JOIN clientes ON ventas.id_cliente = clientes.id ORDER BY ventas.id DESC" : "SELECT ventas.id, ventas.fecha, ventas.total, usuarios.usuario AS nombre_usuario, clientes.nombre AS nombre_cliente FROM ventas JOIN usuarios ON ventas.id_usuario = usuarios.id JOIN clientes ON ventas.id_cliente = clientes.id WHERE ventas.id_usuario = ".$_SESSION['id_usuario']." ORDER BY ventas.id DESC";
                    if ($result = mysqli_query($conexion, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped table_id">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Id</th>";
                            echo "<th>Fecha</th>";
                            echo "<th>Total</th>";
                            echo "<th>Vendedor</th>";
                            echo "<th>Cliente</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fecha'] . "</td>";
                                echo "<td>" . $row['total'] . "</td>";
                                echo "<td>" . $row['nombre_usuario'] . "</td>";
                                echo "<td>" . $row['nombre_cliente'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read_despacho.php?id='. $row['id'] .'" class="mr-3" title="Ver registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update_despacho.php?id='. $row['id'] .'" class="mr-3" title="Modificar registro" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Ningun registro encontrado.</em></div>';
                        }
                    } else{
                        echo "Oops! ERROR.. Intente mas tarde";
                    }

                    // Cerrar coneccion
                    mysqli_close($conexion);
                    ?>
                    <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                     <li class="page-item disabled">
                     <a class="page-link">Anterior</a>
                     </li>
                     <li class="page-item"><a class="page-link" href="#">1</a></li>
                     <li class="page-item"><a class="page-link" href="#">2</a></li>
                     <li class="page-item"><a class="page-link" href="#">3</a></li>
                     <li class="page-item">
                     <a class="page-link" href="#">Siguiente</a>
                    </li>
                 </ul>
                </nav>
</body>
</html>