<?php
session_start();
require_once '../config/parameters.php';
require_once '../Views/header.php';
require_once '../Views/menu.php';

require_once '../Models/pedidosModel.php';
require_once '../Models/productoModel.php';

if (empty($_SESSION['Carrito'])) {
    $_SESSION['Carrito'] = array();
}

?>


<div id="contendor_resumen">
    <a class="menuButton submit" href="pedidos.php?accion=carrito">Ir al carrito
        <?php if ($_SESSION['Carrito']) : ?>
            <p>(<?= count($_SESSION['Carrito']) ?> Item)</p>
        <?php endif ?>
    </a>

    <?php if (count($_SESSION['Carrito']) >= 1) : ?>
        <a class="menuButton submit" href="pedidos.php?accion=listacompra">Continuar con el pedido</a>
    <?php else : ?>
        <a class="menuButton submit" href="pedidos.php?accion=listacompra">Realizar pedido</a>
    <?php endif ?>

    <?php if(isset($_SESSION['admin']) ): ?>
    <a class="menuButton submit" href="pedidos.php?accion=listar">Lista de pedidos </a>
    <?php endif?>



</div>




<?php


if (isset($_GET['accion']) || isset($_POST['accion'])) {
    $accion = $_GET['accion'] ? $_GET['accion'] : $_POST['accion'];
    switch ($accion) {
        case 'listar':
            mostrarLista();

            break;

        case 'confirmar':
            $id = $_POST['pedido_a_confirmar'];
            $pedido =new Pedido();
            $pedido->aceptarPedido($id);
            if ($pedido) {
                header("Location: /index.php");
            }
            break;

        case 'rechazar':
            $id = $_POST['pedido_a_rechazar'];
            $pedido =new Pedido();
            $pedido->rechazarPedido($id);
            if ($pedido) {
                header("Location: /index.php");
            }

            break;
        case 'carrito':

            require_once '../Views/pedidosView/carritoView.php';

            break;
        case 'getpendientes':
            $pedido =new Pedido();
            $pendientes=$pedido->getPedidosPendientes();
            echo $pendientes ;
        break;
        


        case 'listacompra':
            require_once '../Views/pedidosView/listaCompra.php';

            break;
        
        case 'detalle':
            require_once '../Views/pedidosView/detallePedido.php';
            break;
        case 'eliminar_de_carrito':
            $id=$_POST['id'];
            unset($_SESSION['Carrito'][$id]);
            require_once '../Views/pedidosView/carritoView.php';



            break;

        case 'Add_to_Carrito':
            $id = $_POST['id_to_carrito'];
            $cantidad = $_POST['cantidad'];
            $_SESSION['Carrito'][$id] = $cantidad;
            header("Location: pedidos.php?accion=carrito");
            break;

        case 'Confirmar_Carrito':
            $descripcion = $_POST['descripcion'];
            $precio_total = $_POST['precio_total'];

            $pedido_confirmado = new Pedido();
            $confirmacion = $pedido_confirmado->CrearYConfirmar($_SESSION['Carrito'], $descripcion, $precio_total);
            
            if(is_string($confirmacion)){
              
                echo " <p class='mensaje'><b>No se ha podido crear el pedido</b></p>";
           }else{

            unset($_SESSION['Carrito']);
            $_SESSION['Pedidocreado'] = true;
            header("Location: /index.php");
           }




            break;



        default:
            break;
    }
}

?>





<?php
function mostrarLista()
{
    $pedido = new Pedido();
    $todos_pedidos = $pedido->getAllPedidos();



?>

    <div class="table_frame" id="table_result">
        <h2 class="titulo">Todos los pedidos</h2>
        <?php if (isset($_SESSION['Mensaje_pedidos'])) : ?>

            
        <?php endif ?>
        <table>
            <thead>
                <tr>
                    <th>Número de Pedido</th>
                    <th>Realizado por:</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th>Fecha </th>
                    <th>Precio total</th>
                    <th></th>


                </tr>
            </thead>
            <tbody>
                <?php if ($todos_pedidos) : ?>
                    <?php while ($pedido = $todos_pedidos->fetch_assoc()) : ?>
                        <tr>

                            <td><?= $pedido['Pedido_ID'] ?></td>
                            <td><?= $pedido['Empleado_ID'] ?></td>
                            <td>
                                <?php switch ($pedido['Ped_Estado']) {
                                    case '0':
                                       echo 'Pendiente';
                                        break;
                                    case '1':
                                        echo 'Aceptado';
                                        break;
                                    case '2':
                                        echo 'Rechazado';
                                        break;    
                                    
                                    default:
                                        echo '';
                                        break;
                                }  ?>
                            </td>
                            <td><?= $pedido['Ped_Descripcion'] ?></td>
                            <td><?= $pedido['Ped_Fecha'] ?></td>
                            <td><?= $pedido['Ped_Precio_total']?> €</td>
                            <td><a class="a_form" href="pedidos.php?accion=detalle&id=<?=$pedido['Pedido_ID']?>">Mostrar pedido</a></td>
                        </tr>
                    <?php endwhile ?>
                <?php endif ?>
            </tbody>
        </table>

    </div>
<?php
}
?>