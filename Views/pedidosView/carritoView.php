<!--
Esta view se encargara de renderizar todos los elementos en el carrito los cuales
se albergan en $_SESSION['Carrito'].
Por cada elemento de la array se hara una llamada buscando el producto por id y renderizandolo en la vista
-->

<?php
require_once '../Models/productoModel.php';
$producto = new Producto();
$precio_total = 0

?>


    <div class="table_frame">

    <h2 class="titulo">Tu carrito </h2>


        <?php foreach ($_SESSION['Carrito'] as $id_prod => $Cantidad) {
            $producto = new $producto();

            $produc = $producto->getProductoById($id_prod);

            $precio_total = $precio_total + ($produc->Prod_Precio * $Cantidad);
        ?>

            <div class='Carrito '>
            <form action="pedidos.php" method="post">
                <input type="hidden" name="accion" value="eliminar_de_carrito" >
                <input type="hidden" name="id" value=<?=$produc->Prod_ID?> >
                <input type="submit" id="cruz_carrito" value="x"></input> 
            </form>

                <h3><?= $produc->Prod_Nombre ?></h3>
              
                <hr>
                <div id="contenedor_canpre">
                    <h4 class="cuadrado">Precio unidad</h4>
                    <p class="cuadrado"><?= $produc->Prod_Precio ?>€</p>
                    <h4 class="cuadrado">Cantidad </h4>
                    <p class="cuadrado"><?= $Cantidad ?></p>
                </div>

                    <h4>Descripción</h4>
                <p class="apartado_descripcion"><?= $produc->Prod_Descripcion ?></p>
            </div>



        <?php
        }
        ?>
        <div id="precio_total">

            <h2>Costo total del pedido </h2>
            <p><b><?= $precio_total ?> €</b> </p>

        </div>
        <!-- Mostrar cuantos elementos estan en la array por lo tanto en el carrito. --> 

        <?php if(count($_SESSION['Carrito'])>=1):?>
        <div id="form_confirmacion">
            <form action="pedidos.php" method="post">
                <input type="hidden" name="accion" value="Confirmar_Carrito">
                <h4 >Razon del pedido</h4>
                <br>
                <textarea type="text" name="descripcion" cols="50" rows="10"></textarea>
                <input type="hidden" name="precio_total" value="<?= $precio_total ?>">
                <input class="button submit" type="submit" value="Confirmar carrito">
            </form>


        </div>

        <?php else:?>
         <h3 style="text-align: center; ">Actualmente el carrito esta vacio</h3>
        <?php endif?>

    </div>





