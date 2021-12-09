<?php
session_start();
require_once '../config/parameters.php';
require_once '../Views/header.php';
require_once '../Views/menu.php';

require_once '../Models/departamentoModel.php';

?>

<div id="contendor_resumen">

    <a class="menuButton submit" href="departamentos.php?accion=listar">Lista de departamentos </a>
    <a class="menuButton submit " href="departamentos.php?accion=crear">Crear departamento </a>
   
</div>
<?php



if (isset($_GET['accion']) || isset($_POST['accion'])) {
    $accion = $_GET['accion'] ? $_GET['accion'] : $_POST['accion'];


    switch ($accion) {
        
        case 'listar':
            mostrarListaDep();
            
            break;
        case 'crear':
            require_once '../Views/departamentosViews/crear.php';
            break;
        case 'EliminarDep':
            $id = $_POST['id'];
            $departamento= new Departamento();
            $dep_borrado = $departamento->deleteDepartamento($id);
          
            if ($dep_borrado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Departamento borrado satisfactoriamente</p>";
                header('Location: departamentos.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido eliminar  el departamento</p>";
                header('Location: departamentos.php?accion=listar');
            }
            break;
        case 'CrearDep':
            $departamento= new Departamento();
           
            $departamento->setDep_id($_POST['dep_id']);
            $departamento->setNombre($_POST['dep_nombre']);
            $telefono = $_POST['dep_telf'] ? $_POST['dep_telf'] : 'NULL';
            $departamento->setTelf($telefono);

           
            $dep_creado = $departamento->addDepartamento();

            if ($dep_creado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Departamento creado satisfactoriamente</p>";
                header("Location: /index.php");
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido crear el departamento</p>";
                header("Location: /index.php");
            }
            break;

        default:
            break;
    }
}


?>

<?php function mostrarListaDep(){
    $departamento= new Departamento();

    $todos_departarmentos = $departamento->getDepartamentos();

?>
<div class="table_frame" id="table_result">
<h2 class="titulo">Lista de departamentos </h2>

    <table>
        <thead>
            <tr>
                <th>Núm. Departamento</th>
                <th>Nombre de departamento</th>
                <th>Teléfono de contacto</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($todos_departarmentos) : ?>
                <?php while ($dep = $todos_departarmentos->fetch_assoc()) : ?>
                    <?php
                    if ($dep['Dep_Telefono'] == '') {
                        $dep['Dep_Telefono'] = '--';
                    }
                    ?>
                    <tr>
                        <?php if ($dep['Dep_Nombre'] == 'Compras') : ?>
                            <td><?= $dep['Dep_ID'] ?></td>
                            <td><?= $dep['Dep_Nombre'] ?></td>
                            <td><?= $dep['Dep_Telefono'] ?></td>
                        <?php else : ?>
                            <td><?= $dep['Dep_ID'] ?></td>
                            <td><?= $dep['Dep_Nombre'] ?></td>
                            <td><?= $dep['Dep_Telefono'] ?></td>
                            <td>
                                <form class="action_form" action="departamentos.php" method="post">
                                    <input type="hidden" name="accion" value="EliminarDep">
                                    <input type="hidden" name="id" value="<?= $dep['Dep_ID'] ?>">
                                    <input class="button button_input_eliminar" type="submit" value="Eliminar" onclick="return  confirm('Si borra el departamento, los empleados relacionados con el tambien se borraran. Desea continuar?')">
                                </form>


                            </td>

                        <?php endif ?>



                    </tr>
                <?php endwhile ?>
            <?php endif ?>


        </tbody>
    </table>

</div>

<?php } ?>

