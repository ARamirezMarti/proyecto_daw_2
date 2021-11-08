<!-- 
En esta view se mostrara cada pedido en detalle.

-->

<?php
require_once '../Models/pedidosModel.php';
$pedido = new Pedido();

$id_detalle = $_GET['id'];
$detalles = $pedido->getFullPedidoDetalles($id_detalle);

?>

<div class="table_frame">

<h2 class="titulo">Detalles del <?= $id_detalle ?></h2>
<?php if ($detalles) : ?>
    <?php while ($det = $detalles->fetch_assoc()) : ?>
        <?php
        $fecha_realizacion=$det['Ped_Fecha'];
        $empleado=$det['Empleado_ID'];
        $motivos = $det['Ped_Descripcion'];
        $precio_total = $det['Ped_Precio_total'];
        $estado=$det['Ped_Estado'];
        $preciototal_porProducto= $det['Prod_Precio'] * $det['Ped_Cantidad'];
        ?>
            <div class='Carrito'>

               <h2><?=$det['Prod_Nombre']?></h2>
               <hr>
               <h4> Precio <?=$det['Prod_Precio']?> €</h4>
               <h4> Cantidad <?=$det['Ped_Cantidad']?> </h4>
               <p class="apartado_descripcion">Precio total de este producto <?=$preciototal_porProducto?> </p>
            </div>

            <?php endwhile ?>
        <?php endif ?>

        <div class="separator"></div>
        <p><b>Realizacion del pedido:</b> <br><?=$fecha_realizacion ?></p>
        <p><b>Pedido realizado por el empleado:</b>  <br><?=$empleado ?></p>
        <p><b>Motivos del pedido: <br></b><?=$motivos ?></p>
        <p><b>Precio total del pedido:</b><br> <?=$precio_total ?> €</p>

        <div id="botones_conf_rech" ><!-- TODO FALTA CSS EN LOS BOTONES SUBMIT -->

        <?php if($estado == 0 ): ?> 
     
            <form action="pedidos.php" method="post">
                <input type="hidden" name="accion" value="confirmar">
                <input type="hidden" name="pedido_a_confirmar" value="<?=$id_detalle?>">
                <input class="button submit " id="btn_det_acep" type="submit" value="Confirmar"> 

            </form>
            <form action="pedidos.php" method="post">
                <input type="hidden" name="accion" value="rechazar">
                <input type="hidden" name="pedido_a_rechazar" value="<?=$id_detalle?>">
                <input class="button submit " id="btn_det_rech" type="submit" value="Rechazar"> 
            </form>
            
        </div>
        <?php else:?>
            <?php if($estado==1):?>
               <span class="confirm_pedido">Este pedido ha sido aceptado</span>
            <?php elseif($estado==2):?>
                <span class="confirm_pedido">Este pedido ha sido rechazado</span>

            <?php endif?>
        <?php endif?>
            </div>

        </div>
        
    
      