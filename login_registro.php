<?php
//report de errores
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
//Verificacion del user y la pass de los usuarios.

include("conexion.php");

$email= $_POST["email"];
$contraseña= $_POST["contraseña"];


//Login
if(isset($_POST["btningresar"])){

    $sql_consulta = "SELECT * FROM usuario WHERE email = '$email' AND contraseña ='$contraseña'";
    $query = mysqli_query ($conn, $sql_consulta);
    $nr = mysqli_num_rows($query);

    if ($nr==1){
        $row = mysqli_fetch_array($query);

        session_start();
        //Se guardan los datos de la sesion
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['email'];

        //Si es usuario se manda a pedidos pero si es admin a la lista de usuario

        if($row["nivel"]==1){
            echo "<script> alert ('Bienvenido $email'); window.location='inicio_crud.php'</script>";
        }else{
            echo "<script> alert ('Bienvenido $email'); window.location='l_usuarios.php'</script>";
        }


    }else{
        echo "<script> alert ('Usuario no existe'); window.location='login.html'</script>";
    }
}

//Registro del usuario
if(isset($_POST["btnregistrar"])){
    $sqlgrabar = "INSERT INTO usuario (id_usuario, email, contraseña)
    values (NULL, '$email', '$contraseña')";

    if(mysqli_query($conn, $sqlgrabar)){
        echo "<script> alert ('Usuario registrado con exito: $email'); widow.location = 'login.html' </script>";
        header('location:login.html');
    } else {
        echo "Error: ".$sql."<br>".mysqli_error($conn);
    }
}