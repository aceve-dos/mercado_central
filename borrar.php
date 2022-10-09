<?php
//borrar pedidos / productos

include 'funciones.php';

$config = include 'config.php';

$resultado = [
    'error' => false,
    'mensaje' => ''
];

try {
    $dsn = 'mysql:host=' . $config ['db']['host'] . ';dbname=' . $config['db']['name']; 
    $conexion = new PDO($dsn, $config['db']['user'], $config ['db']['pass'], $config['db']['options']);


    $id = $_GET['id_producto'];
    $consultaSQL = "DELETE FROM productos WHERE id_producto=" . $id;


    $sentencia = $conexion ->prepare($consultaSQL);
    $sentencia->execute();

    header('Location:inicio_crud.php');

} catch(PDOException $error){
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
}   
?>

<?php require "templates/header.php"; ?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <?= $resultado ['mensaje'] ?>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
    <input type="submit" name="submit" class="btn btn-primary" value="Enviar">
    <a class="btn btn-primary" href="inicio_crud.php">Regreso al inicio</a>
</div>


<?php require "templates/footer.php"; ?>