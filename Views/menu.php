<?php
session_start();
?>

    <aside>
        <ul>
            <li class="menu_option">

                <div class="menu_img_frame">
                    <img   src="/assets/icons/home.svg" alt="Casa" >
                </div>
                <a href="/index.php">Inicio</a>

            </li>
            <?php if(isset($_SESSION['admin']) ): ?>
                <li class="menu_option">
                    <div class="menu_img_frame">
                        <img  src="/assets/icons/pedidos.svg" alt="Casa" >
                    </div>
                <a href="/Controllers/pedidos.php?accion=listar">Pedidos</a> 
                </li>
            <?php else: ?>
                <li class="menu_option">
                    <div class="menu_img_frame">
                        <img  src="/assets/icons/pedidos.svg" alt="Casa" >
                    </div>
                <a href="/Controllers/pedidos.php?accion=listacompra">Pedidos</a> 
                </li>
            <?php endif ?>

            <?php if(isset($_SESSION['admin']) ): ?>
            <li class="menu_option">
                <div class="menu_img_frame">
                        <img   src="/assets/icons/user.svg" alt="Casa" >
                </div>
                <a href="/Controllers/usuarios.php?accion=listar">Gestion de usuarios</a> 
            </li>

            <li class="menu_option">
                <div class="menu_img_frame">
                    <img   src="/assets/icons/prod.svg" alt="Casa" >
                </div>

               <a href="/Controllers/productos.php?accion=listar">Productos</a> 
            </li>

            <li class="menu_option">
                <div class="menu_img_frame">
                    <img   src="/assets/icons/prov.svg" alt="Casa" >
                </div>
               <a href="/Controllers/proveedores.php?accion=listar">Proveedores</a> 
            </li>

            <li class="menu_option">
                <div class="menu_img_frame">
                    <img  src="/assets/icons/dep.svg" alt="Casa" >
                </div>

               <a href="/Controllers/departamentos.php?accion=listar" >Departamentos</a> 
            </li>
            <?php else : ?>
                
                <li class="menu_option">
                <div class="menu_img_frame">
                        <img   src="/assets/icons/user.svg" alt="Casa" >
                </div> <!-- TODO: ENVIAR A modificacion de usuario -->
                <a href="/Controllers/usuarios.php?accion=configuracion">Gestionar mi cuenta</a> 
            </li>

            <?php endif ?>
        </ul>
       
    </aside>
    