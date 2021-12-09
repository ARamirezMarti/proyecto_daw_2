
<!--
 View para crear proveedores. 
 Se envia por post a Proveedores.php
 -->
<div class="table_frame">

    <div class="create_form">
        <h2 class="titulo">Crear Proveedor</h2>
        <hr>
        <form action="proveedores.php" method="post">
            <input type="hidden" name="accion" value="crearProveedor">
            <label for="prov_nombre">Nombre</label>
            <input type="text" name="prov_nombre" maxlength="75"  required>
            <label for="cif"> No CIF</label>
            <input type="text" maxlength="9" minlength="9" name="prov_cif" required>
            <label for="prov_telf"> Teléfono</label>
            <input type="number" maxlength="9" minlength="9" name="prov_telf" required>
            <label for="prov_web">Página web</label>
            <input type="text" name="prov_web" >
            <label for="prov_calle">Calle</label>
            <input type="text" name="prov_calle" required>
            <label for="pais"> País</label>
            <input type="text" name="prov_pais" required>
            <label for="prov_postal">Código Postal</label>
            <input type="number" name="prov_postal" required>
            <label for="prov_provincia">Provincia</label>
            <input type="text" name="prov_provincia" required>
            <label for="prov_ciudad">Ciudad</label>
            <input type="text" name="prov_ciudad" required>


            <input type="submit" class="button submit" value="Crear">



        </form>

    </div>
</div>