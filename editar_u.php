<?php
//MODIFICACION de usuarios

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id_usuario'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'La clave no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    // $pedidos = [
    //   'id' => $_GET['id'],
    //   'email' => $_POST['email'],
    //   'contraseña' => $_POST['contraseña'],
    //   'nivel' => $_POST['nivel'],
    // ];
    
    // $consultaSQL = "UPDATE usuarios SET
    //     email = :email,
    //     contraseña = :contraseña,
    //     nivel = :nivel,
    //     WHERE id = :id";
    
    $f_id= $_GET['id_usuario'];
    $f_email= $_POST['email'];
    $f_contrasena= $_POST['contraseña'];
    $f_nivel= $_POST['nivel'];
    
    //Parche para que corra la actualizacion
    $consultaSQL = "UPDATE usuario SET email = '$f_email', contraseña = '$f_contrasena', nivel = '$f_nivel' WHERE id_usuario= '$f_id';";
    
    
    $consulta = $conexion->prepare($consultaSQL);
    //$consulta->execute($pedidos);
    $consulta->execute();

  } catch(PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    
  $id = $_GET['id_usuario'];
  $consultaSQL = "SELECT * FROM usuario WHERE id_usuario =" . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $pedidos = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$pedidos) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el usuario';
  }

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<?php
if ($resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
  ?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El usuario ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php
if (isset($pedidos) && $pedidos) {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el usuario <?= escapar($pedidos['email']) ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="email">email</label>
            <input type="text" name="email" id="email" value="<?= escapar($pedidos['email']) ?>" class="form-control" required autofocus>
          </div>
          <div class="form-group">
            <label for="contraseña">contraseña</label>
            <input type="text" name="contraseña" id="contraseña" value="<?= escapar($pedidos['contraseña']) ?>" class="form-control" required autofocus>
          </div>
          <div class="form-group">
            <label for="nombre">nivel</label>
            <input type="text" name="nivel" id="nivel" value="<?= escapar($pedidos['nivel']) ?>" class="form-control" required autofocus>
          </div>
          <br>
          <div class="form-group">
            <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="usuarios_registrados.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php
}
?>

<?php require "templates/footer.php"; ?>