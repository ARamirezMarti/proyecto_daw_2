<!--
En esta view renderizamos el formulario para que el usuario modifique su información.
-->

<?php
require_once '../Models/departamentoModel.php';
require_once '../Models/usuarioModel.php';


$Empleado = new Empleado();
$Empleado->setEmpleado_id( $_SESSION['usuario_id']);

$empleado_actual = $Empleado->getUserbyID();

/* Para que el usuario pueda cambiar de departamento traemos todos los departamentos desde el modelo. */
$departamento= new Departamento();
$departamentos =$departamento->getDepartamentos();

?>

<div class="table_frame">


    <div class="create_form" >
        <h2>Actualizar mis datos</h2>
        <hr>
        <form action="usuarios.php" method="post">
            <input type="hidden" name="accion" value="modificarEmp">
            <input type="hidden" value="<?=$empleado_actual->getEmpleado_id() ?>" name="emp_id"  >
            <input type="hidden" value="<?=$empleado_actual->getPassword() ?>" name="current_pass"  >

            <label for="emp_id"> Numero de empleado </label>
            <input type="number" value="<?=$empleado_actual->getEmpleado_id() ?>" disabled >

            <label for="emp_nombre"> Nombre </label>
            <input type="text"  name="emp_nombre" value=<?=$empleado_actual->getNombre() ?> required>

            <label for="emp_apellidos"> Apellidos </label>
            <input type="text"  name="emp_apellidos" value=<?=$empleado_actual->getApellidos() ?> required>

            <label for="emp_apellidos"> Departamento</label>

            <?php  if($departamentos):?>
                <!-- Mostramos un select con todas las categorias. -->
                <select name="departamento"  >
                    <?php while ($dep = $departamentos->fetch_assoc()) :?>
                        <?php if($empleado_actual->getDep_id() == $dep['Dep_ID']):?>
                            hola
                            <option value="<?=$dep['Dep_ID']?> "selected='selected'  ><?=$dep['Dep_Nombre']?></option>
                        <?php else:?>
                            
                             <option value="<?=$dep['Dep_ID']?>"><?=$dep['Dep_Nombre']?></option>
                        <?php endif ?>
                    <?php  endwhile ?>
                </select>
            
            <?php endif ?>
           
            <label > Password </label>
            <input type="password"   value="<?=$empleado_actual->getPassword() ?>" disabled >

            <label for="emp_pass_nueva">Nueva password </label>
            <input type="password"  name="emp_pass_nueva" >

            <label for="emp_telefono">Telefono</label>
            <input type="number" name="emp_telefono" value=<?=$empleado_actual->getTelf() ?>   >           


            <input type="submit" class="button submit" value="Modificar">

        </form>

    </div>
</div>