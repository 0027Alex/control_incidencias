<?php 
    session_start();
    if($_SERVER['REQUEST_METHOD']=="POST") {
        include "database.php";
        $nombreUsuario=addslashes(trim($_POST['usuario'])) ?? ''; //addslashes: sirve para limpiar la información y que no lleve caracteres raros, trim:sirve para quitar los espacios en blanco y ??'': sirve para mas control si se saltan los dos primeros controles este lo que hara es poner los espacios en blanco.
        $password=addslashes(trim($_POST['password'])) ?? ''; //addslashes: sirve para limpiar la información y que no lleve caracteres raros, trim:sirve para quitar los espacios en blanco y ??'': sirve para mas control si se saltan los dos primeros controles este lo que hara es poner los espacios en blanco.
        if($nombreUsuario=='' || $password=='') { //condicion, si el NombreUsuario ==es igual a ''una cadena vacía, ||ó, e $password es ==igual a una ''cadena vaica.
            exit("Estas intentando hacer algo indebido en el sistema. Te vamos a reportar 😡");  //"die"o "exit" sirven para lo mismo, basicamente banearlo y no dejar en viar los datos  y se le envia una tipo advertencia.
        }
        $query_select = "SELECT * FROM usuarios WHERE nombre_usuario = '".$nombreUsuario."' AND clave_usuario= '".$password."'";
        $result_select = pg_query($conn, $query_select);
            if (!$result_select) {
                die("Error al leer departamentos: " . pg_last_error($conn));
            }
        $row = pg_fetch_assoc($result_select);
        if($row){ //Si el usario y contraseña son correctos y coinciden con los dados, entonces se iniciara sesión
            $_SESSION['usuario']=$nombreUsuario;
                header("location:index.php");
        }else{
            header("location:login.php?error=true"); //si la información es incorrecta te regresa siempre al login para que pongas la información correcta, y de lo contrario si la información es correcta entonces entrara sin problema 
        }
    }
?>