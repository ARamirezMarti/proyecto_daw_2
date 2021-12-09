<?php
session_start();

require_once 'config/parameters.php';
require_once 'Models/usuarioModel.php';


if(isset($_POST['accion']) && $_POST['accion']=='login' ){
    
    $opciones = [
        'cost' => 12,
    ];
    
    $empleado = $_POST['trabajador_id'];
   
    $password = $_POST['password'];
    $usuario = new Empleado();
    $usuario->setEmpleado_id($empleado);
    $usuario->setPassword($password);
    

    $db_user = $usuario->getUserbyID($usuario);  
     /* si no hay db_user esque usuario no existe. variable session indicando que pass o user no existe */
    if($db_user == false){
        $_SESSION["login_error_status"] = 'Usuario o Contraseña incorrectos.';
       
        header('Location: login.php');
    }else if($db_user){
        $password_is_correct=password_verify($password,$db_user->getPassword());
     
        if ( $password_is_correct) {
            
            $_SESSION['usuario_name']= $db_user->getNombre();
            $_SESSION['usuario_id']= $db_user->getEmpleado_id();
            $_SESSION['usuario_dep_id']= $db_user->getDep_id();
        
            header('Location: index.php');

            if($db_user->getIs_respon()==1){
                $_SESSION['admin']=true;
                header('Location: index.php');
            } 
            
        }else{
             /* Si contraseñas NO iguales enviaremos mensaje de usuario/pass incorrecto. */
            $_SESSION['login_error_status']= 'Usuario/password incorrecto.';
            header('Location: login.php');
        }
        

    }   
    
}
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="login_container">
        <h2 id="login_title">Log in</h2>
        <p><?php
            if(isset($_SESSION["login_error_status"])){
                $error = $_SESSION["login_error_status"];
                echo "<span class='alerta   '>$error</span>";
            }
        ?>
        </p>
        <form id="login_form" action="login.php" method="post">
            <input name="accion" type="hidden" value="login">
            <label for="trabajador_id" required>Número trabajador</label>
            <input type="text" name="trabajador_id" required>
            <label for="password">Contraseña</label>
            <input type="password" name="password" required >
            <input class="button submit" type="submit" value="Log In">

        </form>

    </div>
    
</body>
</html>