<!-- En esta view renderizamos el formulario para crear usuarios nuevos -->

<?php
require_once '../Models/departamentoModel.php';


$departamento = new Departamento();
$departamentos= $departamento->getDepartamentos();


?>

<div class="table_frame">


    <div class="create_form" >
        <h2>Crear nuevo usuario</h2>
        <hr>
        <form action="usuarios.php" method="post">
            <input type="hidden" name="accion" value="crearEmp">

            <label for="emp_id"> Numero de empleado </label>
            <input type="number"  name="emp_id" required>

            <label for="emp_nombre"> Nombre </label>
            <input type="text"  name="emp_nombre" required>

            <label for="emp_apellidos"> Apellidos </label>
            <input type="text"  name="emp_apellidos" required>
            
            <label for="emp_password"> Password </label>
            <input type="password"  name="emp_pass" required>

            <label for="emp_telefono">Telefono</label>
            <input type="number" name="emp_telefono"  >
            <?php  if($departamentos):?>
                <!-- Mostramos un select con todas las categorias. -->
                <select name="departamento" >
                    <?php while ($dep = $departamentos->fetch_assoc()) :?>
                        <option value="<?=$dep['Dep_ID']?>"><?=$dep['Dep_Nombre']?></option>
                        
                    <?php  endwhile ?>
                </select>
            
            <?php endif ?>


            <input type="submit" class="button submit" value="Crear">



        </form>

    </div>
</div>