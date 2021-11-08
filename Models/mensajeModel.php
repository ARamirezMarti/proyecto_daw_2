<?php
require_once '../Database/db.php';



class Mensaje
{

    private $Mensaje_ID;
    private $Contenido;
    private $Visto = 0;



    public function getMensaje_ID()
    {
        return $this->Mensaje_ID;
    }



    public function setMensaje_ID($Mensaje_ID)
    {
        $this->Mensaje_ID = $Mensaje_ID;

        return $this;
    }
    public function getContenido()
    {
        return $this->Contenido;
    }


    public function setContenido($contenido)
    {
        $this->Contenido = "Tiene usted un pedido nuevo del empleado " . $contenido;
    }

    public function getVisto()
    {
        return $this->Visto;
    }

    public function setVisto($visto)
    {
        $this->Visto = $visto;
    }

    /* Inserta un mensaje nuevo en la tabla */
    public function createMensaje($pedido_id){
    
        $conn = database::getConnection();
        $query = "INSERT INTO `Mensaje` (`Mensaje_ID`, `Pedido_ID`, `Contenido`, `Visto`) VALUES (NULL, '{$pedido_id}', '{$this->getContenido()}', '{$this->getVisto()}')";
        $crear_mensaje = mysqli_query($conn, $query);

        
        if (!$crear_mensaje) {
            return false;
        }
        mysqli_close($conn);

        return $crear_mensaje;
    }
    /*  Devuelve todos los mensaje de la tabla. */
    public function getAllMensajes(){
        $conn = database::getConnection();
        $query = "SELECT * FROM `Mensaje`";
        $mensajes = mysqli_query($conn, $query);

        
        if (!$mensajes) {
            return false;
        }
        mysqli_close($conn);

        return $mensajes;
    }
    /* Marca un dato como Visto */
    public function marcarComoVisto($id){
        $conn = database::getConnection();
        $query = "UPDATE `Mensaje` SET `Visto` = '1' WHERE `Mensaje`.`Mensaje_ID` = {$id};";
        $marcado = mysqli_query($conn, $query);

        
        if (!$marcado) {
            return false;
        }
        mysqli_close($conn);

        return $marcado;
    }
}
