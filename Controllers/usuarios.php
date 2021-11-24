<?php
session_start();
require_once '../config/parameters.php';
require_once '../Views/header.php';
require_once '../Views/menu.php';
require_once '../Models/usuarioModel.php';

?>

<?php  if(isset($_SESSION['admin']) ) : ?>
    <div id="contendor_resumen">

        <a class="menuButton submit" href="usuarios.php?accion=listar">Listar usuarios</a>
        <a class="menuButton submit" href="usuarios.php?accion=nuevo">Crear usuario</a>

    </div>

<?php endif; ?>

<?php
/* 
* Pasaremos la variable http tanto post como get a la variable $accion para poder definir que accion se tomara a acabo.
*/

if (isset($_GET['accion']) || isset($_POST['accion'])) {
    $accion = $_GET['accion'] ? $_GET['accion'] : $_POST['accion'];

    switch ($accion) {

        case 'listar':
            mostrarEmpleados();

            break;
        case 'crear':
            require_once '../Views/productosViews/crear.php';

            break;
        case 'nuevo':
            require_once '../Views/empleadosViews/crear.php';

            break;
        case 'configuracion':
            require_once '../Views/empleadosViews/actualizar.php';
            
            break;

        case 'modificarEmp':
           
            $empleado = new Empleado();

            $empleado->setEmpleado_id($_POST['emp_id']);
            $empleado->setDep_id($_POST['departamento']);
            $empleado->setNombre($_POST['emp_nombre']);
            $empleado->setApellidos($_POST['emp_apellidos']);

            if($_POST['emp_pass_nueva'] != ''){
                $hashed_password = password_hash($_POST['emp_pass_nueva'], PASSWORD_BCRYPT, ['cost' => '12']);
                $empleado->setPassword($hashed_password);

            }else{
                $empleado->setPassword($_POST['current_pass']);
            }

            $telefono = $_POST['emp_telefono'] ? $_POST['emp_telefono'] : 'NULL';
            $empleado->setTelf($telefono);

            $empleado_modificado =$empleado->updateEmpleado();
           

            if ($empleado_modificado) {
                $_SESSION['usuario_name'] = $empleado->getNombre();
                $_SESSION['Mensaje'] = "<p class='mensaje'>Datos modificados correctamente</p>";
                header("Location: /index.php");
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido modificar los datos</p>";
                header("Location: /index.php");
            }
            

            break;
        case 'crearEmp':

            $empleado = new Empleado();

            $empleado->setEmpleado_id($_POST['emp_id']);

            $empleado->setDep_id($_POST['departamento']);
            $empleado->setNombre($_POST['emp_nombre']);
            $empleado->setApellidos($_POST['emp_apellidos']);


            $hashed_password = password_hash($_POST['emp_pass'], PASSWORD_BCRYPT, ['cost' => '12']);
            $empleado->setPassword($hashed_password);

            $telefono = $_POST['emp_telefono'] ? $_POST['emp_telefono'] : 'NULL';
            $empleado->setTelf($telefono);

            $empleado_creado = $empleado->crearUsuario();;


            if ($empleado_creado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Empleado creado satisfactoriamente</p>";
                header("Location: /index.php");
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido crear el empleado</p>";
                header("Location: /index.php");
            }
            break;

        case 'promocionarEmp':
            $empleado = new Empleado();
            $promocionado = $empleado->promocionarEmpleado($_POST['id']);
            if ($promocionado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Ahora el empleado " . $_POST['id'] . " es administrador del sistema </p>";
                header('Location: usuarios.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido promocionar al usuario  </p>";
                header('Location: usuarios.php?accion=listar');
            }
            break;
        case 'degradarEmp':
            $empleado = new Empleado();
            $degradado = $empleado->degradarEmpleado($_POST['id']);
            if ($degradado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Ahora el empleado " . $_POST['id'] . " es un usuario </p>";
                header('Location: usuarios.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido degradar al usuario</p>";
                header('Location: usuarios.php?accion=listar');
            }
            break;

        case 'eliminarEmp':
            $empleado = new Empleado();
            $eliminado = $empleado->deleteEmpleado($_POST['id']);
            if ($eliminado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>El empleado " . $_POST['id'] . " ha sido eliminado</p>";
                header('Location: usuarios.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido eliminar al usuario</p>";
                header('Location: usuarios.php?accion=listar');
            }
            break;

        default:
            break;
    }
}
?>

<?php function mostrarEmpleados()
{
    $empleados = new Empleado();

    $todos_empleados = $empleados->getAllEmpleadosConDep();

?>
    <div class="table_frame">
    <h2 class="titulo">Lista de usuarios</h2>


        <div class="create_pedidos_form" id="create_form">

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Departamento</th>
                        <th>Telefono</th>
                        <th>Nivel de acceso</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($todos_empleados) : ?>
                        <?php while ($empleado = $todos_empleados->fetch_assoc()) : ?>
                            <tr>

                                <td><?= $empleado['Emp_Nombre'] ?></td>
                                <td><?= $empleado['Emp_Apellido'] ?></td>
                                <td><?= $empleado['Dep_Nombre'] ?></td>
                                <td><?= $empleado['Emp_Telf'] ?></td>
                                <td>
                                    <?php
                                    switch ($empleado['Is_Emp_Respon']) {
                                        case '0':
                                            echo 'Usuario';
                                            break;
                                        case '1':
                                            echo 'Administrador';
                                            break;

                                        default:
                                            break;
                                    } ?>


                                <td>
                                    <?php if ($empleado['Is_Emp_Respon'] == 0) : ?>
                                        <form action="usuarios.php" method="post">
                                            <input type="hidden" name="accion" value="promocionarEmp">
                                            <input type="hidden" name="id" value="<?= $empleado['Empleado_ID'] ?>">
                                            <input class="button button_input_habilitar" type="submit" value="Promocionar " onclick="return  confirm('Seguro que desea promocionar a este empleado a administrador del sistema?')">
                                        </form>
                                    <?php else : ?>
                                        <form action="usuarios.php" method="post">
                                            <input type="hidden" name="accion" value="degradarEmp">
                                            <input type="hidden" name="id" value="<?= $empleado['Empleado_ID'] ?>">
                                            <input class="button button_input_deshabilitar " type="submit" value="Degradar " onclick="return  confirm('Seguro que desea degradar a usuario a este empleado ?')">
                                        </form>
                                        
                                    <?php endif ?>
                                    <hr>
                                    <form class="action_form" action="usuarios.php" method="post">
                                        <input type="hidden" name="accion" value="eliminarEmp">
                                        <input type="hidden" name="id" value="<?= $empleado['Empleado_ID'] ?>">
                                        <input class="button button_input_eliminar " type="submit" value="Eliminar" ">
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    <?php endif ?>
                </tbody>
            </table>


        </div>
    </div>

<?php } ?>