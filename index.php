<?php
session_start();

require_once './config/parameters.php';
require_once 'Views/header.php';
require_once 'Views/menu.php';



if (!isset($_SESSION['usuario_name'])) {
    header('Location: login.php');
}

?>



    <Main>

        
        <?php
         if(isset($_SESSION['admin']) ){
            require_once './Views/resumen.php';

         } 
         
         if (isset($_SESSION['usuario_name']) && !isset($_SESSION['admin'])){
            header('Location: ./Controllers/pedidos.php?accion=listacompra');
         } 

        if (isset($_SESSION['Pedidocreado'])) {
            echo "<p class='mensaje'><b> Pedido creado correctamente</b> </p>";
        }
        
        ?>
        <!-- Mostraremos los mensajes aqui -->
           <?php if (isset($_SESSION['Mensaje'])) : ?>

                <b><?= $_SESSION['Mensaje'] ?></b>
            <?php endif ?>

        <!-- Modal de mensajes -->
            <div id="mensajes_modal" class="mensajecontainer">
                <div class="contenedor_mensajes M_cont_titulo">
                    <button id="cruz">×</button> 
                        <h2>Mensajes</h2>
                        <h4>Ultimos mensajes recibidos</h4> 
                    </div>
                    
           
            </div> 
      
    </Main>


</body>

</html>