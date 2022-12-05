<?php

session_start();

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$error = false;
$config = include 'config.php';

try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    if (isset($_POST['nombre'])) {
        $consultaSQL = "SELECT * FROM usuario WHERE email LIKE '%" . $_POST['nombre'] . "%'";
    } else {
        $consultaSQL = "SELECT * FROM usuario";
    }

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $productos = $sentencia->fetchAll();

} catch(PDOException $error) {
    $error= $error->getMessage();
}

   $titulo = isset($_POST['nombre']) ? 'Lista de Usuarios (' . $_POST['nombre'] . ')' : 'Lista de Usuarios';
?>

<?php include "templates/header.php"; ?>

<?php
if ($error) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $error ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <!-- form de busqueda-->
      <!-- <form method="post" class="form-inline">
        <div class="form-group mr-3">
          <input style="width:80%;float:left;margin-right:5px;" type="text" id="nombre_cliente" name="nombre cliente" placeholder="Buscar por Nombre" class="form-control">
        </div>
        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
        <button type="submit" name="submit" class="btn btn-primary">Ver usuarios</button>
      </form> -->
	    <hr>
      <!-- boton a pantalla de pedidos -->
	    <a href="inicio_crud.php"  class="btn btn-primary mt-4">Ir a pedidos</a>
      <!-- boton de cerrar sesion -->
	  <a href="logout.php"  class="btn btn-secondary mt-4">Cerrar sesión de <?php echo $_SESSION["nombre"] ?> </a>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="mt-3"><?= $titulo ?></h2>
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Email</th>
            <th>Password</th>
            <th>Nivel</th>
          </tr>
        </thead>
        </div>
        <tbody>
          <?php
          if ($productos && $sentencia->rowCount() > 0) {
            foreach ($productos as $fila) {
              ?>
              <tr>
                <td><?php echo escapar ($fila["id_usuario"]);?></td>
                <td><?php echo escapar($fila["email"]); ?></td>
                <td><?php echo escapar($fila["contraseña"]); ?></td>
                <td><?php echo escapar($fila["nivel"]); ?></td>
                <td>
                <!---Editar usuario link aca--->
                <a href="editar_u.php?id_usuario=<?php echo escapar ($fila["id_usuario"]); ?>" class="btn btn-success">Editar</a>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        <tbody>
      </table>
    </div>
  </div>
</div>

<?php include "templates/footer.php"; ?>


