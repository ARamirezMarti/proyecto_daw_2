<?php
session_start();
require_once '../config/parameters.php';
require_once '../Views/header.php';
require_once '../Views/menu.php';

require_once '../Models/proveedorModel.php';
require_once '../Models/direccionModel.php';


?>

<div id="contendor_resumen">

    <a class="menuButton submit" href="proveedores.php?accion=listar">Listar Proveedores</a>
    <a class="menuButton submit" href="proveedores.php?accion=crear">Añadir proveedor</a>

</div>


<?php



if (isset($_GET['accion']) || isset($_POST['accion'])) {
    $accion = $_GET['accion'] ? $_GET['accion'] : $_POST['accion'];


    switch ($accion) {

        case 'listar':
            mostrarListaProveedores();

            break;
        case 'crear':
            require_once '../Views/proveedoresViews/crear.php';
            break;
        case 'deshabilitarProveedor':
            $id = $_POST['id'];
            $proveedor = new Proveedor();
            $prov_deshabilitado = $proveedor->deshabilitarProveedor($id);

            if ($prov_deshabilitado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Proveedor deshabilitado satisfactoriamente</p>";
                header('Location: proveedores.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido deshabilitar  el proveedor</p>";
                header('Location: proveedores.php?accion=listar');
            }
            break;
        case 'habilitarProveedor':
            $id = $_POST['id'];
            $proveedor = new Proveedor();
            $prov_habilitado = $proveedor->habilitarProveedor($id);

            if ($prov_habilitado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Proveedor habilitado satisfactoriamente</p>";
                header('Location: proveedores.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido habilitar  el Proveedor</p>";
                header('Location: proveedores.php?accion=listar');
            }
            break;


        case 'crearProveedor':

           

            $direccion=new Direccion();
            $direccion->setCalle($_POST['prov_calle']);
            $direccion->setPais($_POST['prov_pais']);
            $direccion->setCod_postal($_POST['prov_postal']);
            $direccion->setProvincia($_POST['prov_provincia']);
            $direccion->setCiudad($_POST['prov_ciudad']);
            
            $direccion_creada = $direccion->crearDireccion();

            if ($direccion_creada) {
                $id = $direccion->getIdDireccion()->fetch_object();
              
                $proveedor = new Proveedor();
                $proveedor->setProv_dir_id($id->Direccion_ID);
                $proveedor->setNombre($_POST['prov_nombre']);
                $proveedor->setCif($_POST['prov_cif']);
                $proveedor->setTelf($_POST['prov_telf']);
                $web = $_POST['prov_web'] ? $_POST['prov_web'] : 'NULL';
                $proveedor->setWeb($web);

               $resultado= $proveedor->crearProveedor($id);
            }

            if ($resultado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Proveedor creado satisfactoriamente</p>";
                header("Location: /index.php");
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido crear el proveedor</p>";
                header("Location: /index.php");
            }

        default:
            break;
    }
}


?>

<?php function mostrarListaProveedores()
{
    $proveedor = new Proveedor();

    $todos_proveedores = $proveedor->getAllProveedores();

?>
    <div class="table_frame">
        <h2 class="titulo">Lista de proveedores</h2>

        <div class="create_pedidos_form" id="create_form">

            <table>
                <thead>
                    <tr>
                        <th>Nombre del proveedor</th>
                        <th>CIF</th>
                        <th>Teléfono</th>
                        <th>Página Web</th>
                        <th>Dirección</th>
                        <th>Código Postal</th>
                        <th>Ciudad</th>
                        <th>Provincia</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php if ($todos_proveedores) : ?>
                        <?php while ($proveedor = $todos_proveedores->fetch_assoc()) : ?>
                            <tr>

                                <td><?= $proveedor['Prov_Nombre'] ?></td>
                                <td><?= $proveedor['Prov_CIF'] ?></td>
                                <td><?= $proveedor['Prov_Telf'] ?></td>
                                <td><?php
                                    if ($proveedor['Prov_Web']) : ?>
                                        <a href="<?= $proveedor['Prov_Web'] ?>"><?= $proveedor['Prov_Nombre'] ?></a>
                                </td>
                            <?php else : ?>
                                No Disponible
                            <?php endif ?>


                            <td><?= $proveedor['Dir_Calle'] ?></td>
                            <td><?= $proveedor['Dir_Cod_Postal'] ?></td>
                            <td><?= $proveedor['Dir_Ciudad'] ?></td>
                            <td><?= $proveedor['Dir_Provincia'] ?></td>
                            <td>
                                <?php if ($proveedor['Enabled'] == 0) : ?>
                                    <form class="action_form" action="proveedores.php" method="post">
                                        <input type="hidden" name="accion" value="deshabilitarProveedor">
                                        <input type="hidden" name="id" value="<?= $proveedor['Prov_ID'] ?>">
                                        <input class="button button_input_eliminar " type="submit" value="Deshabilitar" ">
                                </form>
                            <?php else : ?>
                                <form class="action_form" action=" proveedores.php" method="post">
                                        <input type="hidden" name="accion" value="habilitarProveedor">
                                        <input type="hidden" name="id" value="<?= $proveedor['Prov_ID'] ?>">
                                        <input class="button button_input_crear " type="submit" value="Habilitar" ">
                                </form>

                            <?php endif ?>
                            
                            </td>
                            
                        </tr>
                    <?php endwhile ?>
                <?php endif ?>
            </tbody>
        </table>


    </div>
</div>
<?php } ?>