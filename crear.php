<?php
//Pedidos del puestero

include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])){
    die();
}
if (isset($_POST['submit'])){
    $resultado = [
        'error' => false,
        'mensaje' => 'Se creo con éxito'
    ];
    $config = include 'config.php';
    
    try{
        $dsn = 'mysql:host=' . $config ['db']['host'] . ';dbname=' . $config ['db']['name'];
        $conexion = new PDO($dsn, $config ['db']['user'], $config ['db']['pass'], $config['db']['options']);

        $producto = [
            "producto_nombre" => $_POST ['nombre'],
            "sub_producto" => $_POST['subprod'],
            "cantidad" => $_POST['cantidad'],
            "tipo" => $_POST['tipo'], 
            "peso" => $_POST ['peso'],
            "precio_max" => $_POST ['preciomax'],
            "precio_min" => $_POST ['preciomin'] 
        ];

        $consultaSQL = "INSERT INTO productos(producto_nombre, sub_producto, cantidad, tipo, peso, precio_max, precio_min)";
        $consultaSQL .="values(:" .implode(", :", array_keys($producto)) . ")";

        $sentencia = $conexion -> prepare($consultaSQL);
        $sentencia ->execute($producto);

    } catch(PDOException $error){
        $resultado['error'] = true;
        $resultado ['mensaje'] = $error ->getMessage();
    }
}
?>


<?php include 'templates/header.php';?>

<?php
if (isset($resultado)) {
    ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success'?>" role="alert">
                    <?= $resultado ['mensaje']?>
                </div>
            </div>
        </div>
    </div>
    <?php

}
?>

<!-- FORM de los productos --->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Agregar Producto</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="nombre">Nombre producto</label>
                    <input type="text" name="nombre" id="nombre"
                    class="form-control"
                    maxlength="255" required autofocus>
                </div>
                <div class="form-group">
                    <label for="sub_producto">Sub Producto</label>
                    <select name="subprod" id="subprod" class="form-control" required  >Sub Productos
                    <option value="0">Seleccione</option>
                    <option value="Bananas">Bananas</option>
                    <option value="Manzanas">Manzanas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="text"
                    id="cantidad"
                    name="cantidad" class="form-control" min="0" max="100000" required>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo de Producto</label>
                    <input type="text" name="tipo"
                    id="tipo"
                    class="form-control" maxlength="255"required>
                </div>
                <div class="form-group">
                    <label for="peso">Peso</label>
                    <input type="text"
                    name="peso"
                    id="peso"
                    class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio_max"> Precio Max</label>
                    <input type="text" name="preciomax" id="precio_max" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="precio_min"> Precio Min</label>
                    <input type="text" name="preciomin" id="precio_min" class="form-control" required>
                </div>
                <div class="form group">
                    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']);?>">

                    <!--Se guarda el usuario ocultandolo--->
                    <input name="id_usuario" type="hidden" value="<?php echo escapar($_SESSION['id_usuario']);?>">
                    <input type="submit" name="submit" class="btn btn-primary" value="Confirmar">
                    <a class="btn btn-info" href="inicio_crud.php">Regresar al comienzo</a>
                </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>