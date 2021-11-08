<?php

require_once '../Models/pedidosModel.php';
require_once '../Models/mensajeModel.php';



if (isset($_GET['peticion']) || isset($_POST['peticion'])) {
    $peticion = $_GET['peticion'] ? $_GET['peticion'] : $_POST['peticion'];

    switch ($peticion) {
        case 'getpendientes':
            $pedido =new Pedido();
            $pendientes=$pedido->getPedidosPendientes();
            $confirmados = $pedido->getPedidosConfirmados();
            $rechazados = $pedido ->getPedidosRechazados();
            $request_estados = array("pendientes"=>$pendientes, "confirmados"=>$confirmados,  "rechazados"=>$rechazados);

            $estados_json = json_encode($request_estados);

            echo $estados_json ;
        break;

        case 'getmensajes':
            $mensajes= new Mensaje();
            $array_mensajes= array();
            $allMensajes=$mensajes->getAllMensajes();
            
            while ($men = $allMensajes->fetch_assoc()) {
             
               array_push($array_mensajes,array("mensajeid"=>$men['Mensaje_ID'],'contenido'=>$men['Contenido'],"visto"=>$men['Visto']));
            }

            $allmensajes_json= json_encode($array_mensajes);
            
            echo $allmensajes_json;
        
        case 'mensajevisto':
            $mensaje= new Mensaje();
            $resultado=$mensaje->marcarComoVisto($_GET['id']);

            echo $resultado;
            
            break;


        
        default:
            break;
    }

}