<?php
session_start();
require_once '../config/parameters.php';
require_once '../Views/header.php';
require_once '../Views/menu.php';

require_once '../Models/productoModel.php';

?>

<div id="contendor_resumen">

    <a class="menuButton submit" href="productos.php?accion=listar">Listar productos</a>
    <a class="menuButton submit" href="productos.php?accion=crear">Crear producto</a>
   
</div>

<div class="input_busqueda">
    <form action="productos.php" method="GET">
        <input type="hidden" name="accion" value="buscar">    
        <input id="sarch_input" id="search" type="text" name="nombre" placeholder="Buscar producto">
        <input id="boton_search" type="submit" value="Search">
    </form>
</div>

<?php if (isset($_SESSION['Mensaje'])) : ?>

<b><?= $_SESSION['Mensaje'] ?></b>
<?php endif ?>

<?php



if (isset($_GET['accion']) || isset($_POST['accion'])) {
    $accion = $_GET['accion'] ? $_GET['accion'] : $_POST['accion'];


    switch ($accion) {

        case 'listar':
            mostrarListaProd();

            break;
        case 'buscar':
            mostrarBuscados($_GET['nombre']);         
    
            break;
        case 'crear':
            require_once '../Views/productosViews/crear.php';
            break;
        case 'deshabilitarProd':
            $id = $_POST['id'];
            $producto = new Producto();
            $prod_borrado = $producto->deshabilitarProducto($id);

            if ($prod_borrado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Producto deshabilitado satisfactoriamente</p>";
                header('Location: productos.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido deshabilitar  el producto</p>";
                header('Location: productos.php?accion=listar');
            }
            break;
        case 'habilitarProd':
            $id = $_POST['id'];
            $producto = new Producto();
            $prod_borrado = $producto->habilitarProducto($id);

            if ($prod_borrado) {
                header('Location: productos.php?accion=listar');
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido habilitar  el producto</p>";
                header('Location: productos.php?accion=listar');
            }
            break;


        case 'crearProd':

          
            $producto = new Producto();
            $producto->setNombre($_POST['prod_nombre']);
            $producto->setDescripcion($_POST['prod_desc']);
            $producto->setPrecio($_POST['prod_precio']);
            $producto->setProv_id($_POST['proveedor']);
            $producto->setCat_id($_POST['categoria']);
            
            $producto_creado= $producto->crearProducto();
            
        
            

            if ($producto_creado) {
                $_SESSION['Mensaje'] = "<p class='mensaje'>Producto creado satisfactoriamente</p>";
                header("Location: productos.php?accion=listar");
            } else {
                $_SESSION['Mensaje'] = "<p class='mensaje'>No se ha podido crear el producto    </p>";
                header("Location: productos.php?accion=listar");
            }

        default:
            break;
    }
}


?>




<?php function mostrarListaProd()
{
    $producto = new Producto();

    $todos_productos = $producto->getAllProductos();

?>
    <div class="table_frame">
    <h2 class="titulo">Lista de productos</h2>
    
    <div class="create_pedidos_form" id="create_form">
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Nombre del producto</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($todos_productos) : ?>
                    <?php while ($producto = $todos_productos->fetch_assoc()) : ?>
                        <tr>

                            <td><?= $producto['Prod_Nombre'] ?></td>
                            <td><?= $producto['Prod_Descripcion'] ?></td>
                            <td><?= $producto['Prod_Precio'] ?></td>
                            <td>
                                <?php if ($producto['Enabled'] == 0) : ?>
                                    <form class="action_form" action="productos.php" method="post">
                                        <input type="hidden" name="accion" value="deshabilitarProd">
                                        <input type="hidden" name="id" value="<?= $producto['Prod_ID'] ?>">
                                        <input class="button button_input_eliminar" type="submit" value="Deshabilitar" ">
                                    </form>
                            <?php else : ?>
                                <form class="action_form" action=" productos.php" method="post">
                                        <input type="hidden" name="accion" value="habilitarProd">
                                        <input type="hidden" name="id" value="<?= $producto['Prod_ID'] ?>">
                                        <input class="button button_input_crear" type="submit" value="Habilitar" ">
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

<?php }; ?>

<?php function mostrarBuscados($nombre)
{
    $producto = new Producto();

    $productos_encontrados = $producto->getProductoBuscadosNombre($nombre);

?>
    <div class="table_frame">
    <h2 class="titulo">Lista de productos</h2>
    
    <div class="create_pedidos_form" id="create_form">
        <hr>

        <table>
            <thead>
                <tr>
                    <th>Nombre del producto</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($productos_encontrados) : ?>
                    <?php while ($producto = $productos_encontrados->fetch_assoc()) : ?>
                        <tr>

                            <td><?= $producto['Prod_Nombre'] ?></td>
                            <td><?= $producto['Prod_Descripcion'] ?></td>
                            <td><?= $producto['Prod_Precio'] ?></td>
                            <td>
                                <?php if ($producto['Enabled'] == 0) : ?>
                                    <form class="action_form" action="productos.php" method="post">
                                        <input type="hidden" name="accion" value="deshabilitarProd">
                                        <input type="hidden" name="id" value="<?= $producto['Prod_ID'] ?>">
                                        <input class="button button_input_eliminar" type="submit" value="Deshabilitar" ">
                                    </form>
                            <?php else : ?>
                                <form class="action_form" action=" productos.php" method="post">
                                        <input type="hidden" name="accion" value="habilitarProd">
                                        <input type="hidden" name="id" value="<?= $producto['Prod_ID'] ?>">
                                        <input class="button button_input_crear" type="submit" value="Habilitar" ">
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