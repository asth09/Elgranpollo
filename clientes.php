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
	<title>Clientes</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="shortcut icon" href="LOGO EL GRAN POLLO.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel='stylesheet' type='text/css' media='screen' href='styles.css'>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
	<div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="mt-5 mb-3 clearfix">
						<h2 class="pull-left" id="clientes">Clientes</h2>
						<a href="create_clientes.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Agregar un cliente</a>
					</div>
					<div class="container-fluid">
						<form class="d-flex">
							<input class="form-control me-2 light-table-filter" data-table="table_id" type="text" placeholder="Buscar:">
							<hr>
						</form>
					</div>
					<br>
					<!-- Copiar desde aqui -->
					<?php
						// Incluir configuracion de la Base de Datos
						require_once "conexion_bd.php";

						// Comprobar si el usuario es el administrador
						$esAdmin = isset($_SESSION['es_admin']) && $_SESSION['es_admin'];
						
						// Si el usuario es admin, mostrar todos los clientes. De lo contrario, solo los asignados a él.
						$sql = $esAdmin ? "SELECT * FROM clientes" : "SELECT * FROM clientes WHERE vendedor = '" . $_SESSION['usuario'] . "'";

						if($result = mysqli_query($conexion, $sql)){
							if(mysqli_num_rows($result) > 0){
								echo '<table class="table table-bordered table-striped table_id" id="tblDatos">';
									echo "<thead>";
										echo "<tr>";
											echo "<th>id</th>";
											echo "<th>nombre</th>";
											echo "<th>rif</th>";
											echo "<th>direccion</th>";
											echo "<th>telefono</th>";
											echo "<th>vendedor</th>";
										echo "</tr>";
									echo "</thead>";
									echo "<tbody>";
									while($row = mysqli_fetch_array($result)){
										echo "<tr>";
											echo "<td>" . $row['id'] . "</td>";
											echo "<td>" . $row['nombre'] . "</td>";
											echo "<td>" . $row['rif'] . "</td>";
											echo "<td>" . $row['direccion'] . "</td>";
											echo "<td>" . $row['telefono'] . "</td>";
											echo "<td>" . $row['vendedor'] . "</td>";
											echo "<td>";
												echo '<a href="read_clientes.php?id='. $row['id'] .'" class="mr-3" title="Ver registro" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
												echo '<a href="update_clientes.php?id='. $row['id'] .'" class="mr-3" title="Modificar registro" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
												echo '<a href="delete_clientes.php?id='. $row['id'] .'" title="Borrar registro" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
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
				</div>
			</div>
		</div>
	</div>
</body>
</html>