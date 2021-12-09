
<!-- Pintamos el search bar -->
<div class="input_busqueda">

    <form action="pedidos.php?accion=listacompra.php" method="GET">
        <input type="hidden" name="accion" value="listacompra">  
        <input type="hidden" name="accion2" value="buscar">    
        <input id="sarch_input" type="text" name="nombre" placeholder="Buscar producto">
        <input  id="boton_search" type="submit" value="Search">
    </form>
</div>


<!--
     Si se recibe la variable "accion2" significa que el usuario a buscado en la search bar
     por lo tanto mediante la funcion "mostrarBuscados" mostraremos los producto que se encuentren
     en la base de datos
 -->
<?php 
 if(isset($_GET['accion2']) && $_GET['accion2']=='buscar'){
   mostrarBuscados($_GET['nombre']);         

      
 }else{
     /* Si no se recibe la accion2, mostraremos toda la lista de todos los productos. */
     mostrarListaPedido();
 }
?>
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
            <th>Descripción</th>
            <th>Precio</th>
            <th>Pedir</th>
            
        </tr>
        </thead>
        <tbody>
        <?php if ($productos_encontrados) :?> 
               <?php while ($producto = $productos_encontrados->fetch_assoc()) :?>
                <tr>
         
                    <td><?=$producto['Prod_Nombre']?></td>
                    <td><?=$producto['Prod_Descripcion']?></td>
                    <td><?=$producto['Prod_Precio']?>€</td>
                    <td>
                    <form action="pedidos.php" method="post">
                        
                        <input type="hidden" name="accion" value="Add_to_Carrito" >
                        <input type="hidden" name="id_to_carrito" value="<?=$producto['Prod_ID']?>">
                        <input class="input_cantidad" type="number" name="cantidad" min="1" value="0">

                        <input class="button submit spacer " type="submit" value = "Pedir">

                    </form>


                </td>
                </tr>
            <?php  endwhile ?>
        <?php endif ?>
        </tbody>
    </table>


    </div>
    </div>

<?php }; ?>

<?php function mostrarListaPedido()
{
 require_once '../Models/productoModel.php';

$producto = new Producto();
$todos_productos = $producto->getAllEnabledProductos();

?>

<div class="table_frame">

<div class="create_pedidos_form" id="create_form">
    <h2>Realizar Pedido</h2>
    <hr>

    <table>
        <thead>
        <tr>
            <th>Nombre del producto</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Pedir</th>
            
        </tr>
        </thead>
        <tbody>
        <?php if ($todos_productos) :?> 
               <?php while ($producto = $todos_productos->fetch_assoc()) :?>
                <tr>
         
                    <td><?=$producto['Prod_Nombre']?></td>
                    <td><?=$producto['Prod_Descripcion']?></td>
                    <td><?=$producto['Prod_Precio']?>€</td>
                    <td>
                    <form action="pedidos.php" method="post">
                        
                        <input type="hidden" name="accion" value="Add_to_Carrito" >
                        <input type="hidden" name="id_to_carrito" value="<?=$producto['Prod_ID']?>">
                        <input class="input_cantidad" type="number" name="cantidad" min="1" value="0">

                        <input class="button submit spacer " type="submit" value = "Pedir">


                    </form>


                </td>
                </tr>
            <?php  endwhile ?>
        <?php endif ?>
        </tbody>
    </table>
    

</div>

</div>
<?php } ?>