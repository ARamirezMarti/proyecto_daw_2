
<!--
 View para crear Productos. 
 Se envia por post a Proveedores.php
 -->

<div class="table_frame">
    
<?php


require_once '../Models/proveedorModel.php';
require_once '../Models/categoriasModel.php';

/* Para poder crear productos, debemos representar los proveedores y las categorias para que el usuario eliga. */
$proveedores= new Proveedor();
$all_proveedores = $proveedores->getAllProveedores();
$categorias= new Categorias();
$all_Categorias= $categorias->getAllCategorias();

?>
    <div class="create_form">
    <h2 class="titulo">Crear producto</h2>

        <hr>
        <form action="productos.php" method="post">
            <input type="hidden" name="accion" value="crearProd">
            <label for="prod_nombre">Nombre del producto</label>
            <input type="text" name="prod_nombre" maxlength="75"  required>

            <label for="prod_desc"> Descripción</label>
            <textarea type="text" name="prod_desc" rows="10" cols="35" maxlength="255" required></textarea>
            
            <label for="prod_precio"> Precio</label>
            <input type="number" step=".01" min="0" placeholder="0,0" name="prod_precio" required>

            
            <label for="prod_proveedor"> Proveedor </label>

        <!-- Mediante select representamos los proveedores y las categorias -->
            <?php  if($all_proveedores):?>
                <select name="proveedor" >
                    <?php while ($prov = $all_proveedores->fetch_assoc()) :?>
                        <option value="<?=$prov['Prov_ID']?>"><?=$prov['Prov_Nombre']?></option>
                        
                    <?php  endwhile ?>
                </select>
            
            <?php endif ?>

            <label for="prod_proveedor"> Categoría </label>

            <?php  if($all_Categorias):?>
                <select name="categoria" >
                    <?php while ($cat = $all_Categorias->fetch_assoc()) :?>
                        <option value="<?=$cat['Cat_ID']?>"><?=$cat['Cat_Nombre']?></option>
                        
                    <?php  endwhile ?>
                </select>
            
            <?php endif ?>

            <input type="submit" class="button submit" value="Crear">
        </form>

    </div>
</div>