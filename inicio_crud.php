<?php
//lista de productos
session_start();
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'],$_POST['csrf'])) {
    die();
}

$error = false;
$config = include 'config.php';

try {
    $dsn ='mysql:host=' .  $config['db']['host'] . ';dbname=' . $config ['db']['name'];
    $conexion = new PDO($dsn, $config ['db']['user'], $config['db']['pass'], $config ['db']['options']);

    //if(isset($_POST['nombre_puestero'])){
    //    $consultaSQL = "SELECT * FROM productos WHERE nombre_puestero LIKE '%" . $_POST['nombre_puestero'] . "%'";
    //} else {
    //    if ($_SESSION ['nivel']==1){
    //        $consultaSQL = "SELECT * FROM productos WHERE nombre_puestero=" . $_SESSION["nombre_puestero"];
    //    }else{
    //        $consultaSQL = "SELECT * FROM productos";
    //    }
    //}

    $consultaSQL = "SELECT * FROM productos";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $productos = $sentencia->fetchAll();
} catch (PDOException $error){
    $error = $error->getMessage();
}
    $titulo = isset($_POST['nombre_puestero']) ? 'Pedidos (' . $_POST['nombre_puestero'] . ')' : 'Pedidos';

//aca va un IF que determina el nivel de usuario si es admin o no, para luego dar consulta a la base de datos desde la tabla de productos y mostrar dichos productos. 

?>
<?php include "templates/header.php"; ?>

<?php
if ($error) {
    ?>
    <div class="container m-2">
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
            <!-- <form method="post" class="form-inline">
                <div class="form-group mr-3">
                    <input type="text" style="width:80%; float:left margin:right 5px"; id="nombre_puestero" name="nombre_puestero" placeholder="Buscar por nombre" class="form-control">
                </div>
                <input name="csrf" type="hidden" value="<?php echo escapar ($_SESSION['csrf']); ?>">
                <button type="submit" name="submit" class="btn btn-primary">    
                    Ver Productos
                </button>
            </form> -->
            <hr>
            <!---Boton de lista de usuarios o productos, voy viendo.--->
            
            <?php
            //    if($_SESSION['nivel']==2){
            //        echo'<a href="l_usuarios.php" class="btn btn-primary ,t-4"> Productos</a>';
            //    }
            ?>
            <!-- BOTONES DE MENU -->
            <!---Agregar pedido--->
            <a href="crear.php" class="btn btn-primary mt-4">Agregar pedido</a>
            <a href="logout.php" class="btn btn-primary mt-4">Cerrar sesión de: <?php echo $_SESSION['nombre'] ?></a>
            <?php if($_SESSION['nivel']==2){?>
                <a href="usuarios_registrados.php" class="btn btn-primary mt-4">Volver a Usuarios Registrados</a>
            <?php
            }                        
            ?>    <!---Cerrar sesion--->

        </div>
    </div>
</div>

<!---BOTON DE BUSCAR PRODUCTO.--->
<!---CRUD--->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-3"><?=$titulo ?></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre Puestero</th>
                        <th>ID Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Sub producto</th>
                        <th>Cantidad</th>
                        <th>Tipo de Embalaje</th>
                        <th>Peso</th>
                        <th>Precio Maximo</th>
                        <th>Precio Minimo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($productos && $sentencia ->rowCount() > 0){
                        foreach ($productos as $fila) {
                            ?>
                            <tr>
                                <td><?php echo escapar ($fila['nombre_puestero']); ?></td>
                                <td><?php echo escapar ($fila['id_producto']); ?></td>
                                <td><?php echo escapar ($fila['producto_nombre']); ?></td>
                                <td><?php echo escapar ($fila['sub_producto']); ?></td>
                                <td><?php echo escapar ($fila['cantidad']); ?></td>
                                <td><?php echo escapar ($fila['tipo']); ?></td>
                                <td><?php echo escapar ($fila['peso']); ?></td>
                                <td><?php echo escapar ($fila['precio_max']); ?></td>
                                <td><?php echo escapar ($fila['precio_min']); ?></td>
                                <td>
                                    <?php if($_SESSION['nivel']==2){?>
                                        <a href="<?= 'borrar.php?id=' . escapar ($fila['id_producto']) ?>"> Borrar</a>
                                        <a href="<?= 'editar.php?id=' . escapar($fila['id_producto']) ?>">Editar</a>      
                                </td>
                            </tr>
                            <?php
                    }
                }
            }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "templates/footer.php"; ?>
