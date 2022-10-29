<!---Modif de pedidos--->
<?php

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

//Editar el GET ID al verificar cual corresponde.
if (!isset($_GET['id'])) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'La clave no existe';
}

?>

<?php require "templates/header.php"; ?>

<?php
if ($resultado['error']) {
    ?>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger"role="alert">
                    <?= $resultado['mensaje'] ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']){
    $dsn = 'mysql:host=' . $config ['db']['host'] . ';dbname=' . $config ['db']['name'];
    $conexion = new PDO($dsn, $config ['db']['user'], $config ['db']['pass'], $config ['db']['options']);

    //Aca se capturan los valores
    $nombre_puestero = $_POST['nombre_puestero'];
    $producto_nombre= $_POST['producto_nombre'];
    $sub_producto= $_POST['sub_producto'];
    $cantidad= $_POST['cantidad'];
    $tipo= $_POST['tipo'];
    $peso= $_POST['peso'];
    $precio_max= $_POST['precio_max'];
    $precio_min = $_POST['precio_min'];
    $id_producto=$_POST['id_producto'];

    //UPDATE de consulta SQL
    $consultaSQL = "UPDATE productos SET
    nombre_puestero = :nombre_puestero,
    producto_nombre= :producto_nombre,
    sub_producto = :sub_producto,
    cantidad = :cantidad,
    tipo = :tipo,
    peso = :peso,
    precio_max = :precio_max,
    precio_min = precio_min
    WHERE id_producto = :id_producto";


    $sentencia = $conexion->prepare($consultaSQL);


    //Parametros

    $sentencia->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
    $sentencia->bindParam(':producto_nombre', $producto_nombre, PDO::PARAM_INT);
    $sentencia->bindParam(':sub_producto', $sub_producto, PDO::PARAM_INT);
    $sentencia->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
    $sentencia->bindParam(':tipo', $tipo, PDO::PARAM_INT);
    $sentencia->bindParam(':peso', $peso, PDO::PARAM_INT);
    $sentencia->bindParam(':precio_max', $precio_max, PDO::PARAM_INT);
    $sentencia->bindParam(':precio_min', $precio_min, PDO::PARAM_INT);
    $sentencia->bindParam(':nombre_puestero', $nombre_puestero, PDO::PARAM_INT);

    $sentencia->execute($producto);

    ?>
    <div class="container m2-2">
        <div class="col-md-12">
            <div class="alert alert-sucess" role="alert">
                    El producto se actualizó.
            </div>
        </div>
    </div>
    <?php
}
?>



<?php
if (isset($productos) && $productos){
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-4">Edicion de productos y pedidos <?= escapar($productos['nombre_puestero']) ?> </h2>
                <hr>
                <form method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre de Producto</label>
                        <input type="text" name="producto_nombre" id="nomprod" value="<?= escapar($productos['producto_nombre']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Sub Producto</label>
                        <input type="text" name="sub_producto" id="subprod" value="<?= escapar($productos['sub_producto']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Cantidad</label>
                        <input type="text" name="cantidad" id="cantidad" value="<?= escapar($productos['cantidad']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Tipo</label>
                        <input type="text" name="tipo" id="tipo" value="<?= escapar($productos['tipo']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Peso</label>
                        <input type="text" name="peso" id="peso" value="<?= escapar($productos['peso']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Precio Maximo</label>
                        <input type="text" name="precio_max" id="preciomax" value="<?= escapar($productos['precio_max']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Precio Minimo</label>
                        <input type="text" name="precio_min" id="preciomin" value="<?= escapar($productos['precio_min']) ?>" class="form-control" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre Puestero</label>
                        <input type="text" name="nombre_puestero" id="nombrepuestero" value="<?= escapar($productos['nombre_puestero']) ?>" class="form-control" required autofocus>
                    </div>

                    <div class="form-group">
                        <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
                        <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
                        <a href="inicio_crud" class="btn btn-primary">Regreso al inicio</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php require "templates/footer.php"?>
