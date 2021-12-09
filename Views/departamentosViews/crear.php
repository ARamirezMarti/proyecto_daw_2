<div class="table_frame">

    <div class="create_form"> 
        <h2 class="titulo"> Crear Departamento </h2>
        <hr>
        <form action="departamentos.php" method="post">
            <input type="hidden" name="accion" value="CrearDep">

            <label for="dep_id">Número departamento</label>
            <input type="number" name="dep_id" min="1" value="0" max="10000" required>
            <label for="dep_nombre"> Nombre del departamento</label>
            <input type="text" maxlength="100" name="dep_nombre" required>
            <label for="dep_nombre"> Teléfono</label>
            <input type="text" maxlength="9" minlength="9" name="dep_telf">

            <input  type="submit" class="button submit" value="Crear">



        </form>

    </div>
</div>