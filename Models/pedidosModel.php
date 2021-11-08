<?php

require_once '../Database/db.php';
require_once 'productoModel.php';
require_once 'mensajeModel.php';



class Pedido
{

    private $pedido_id;
    private $empleado_id;
    private $estado;
    private $descripcion;
    private $fecha;
    private $precio_total;



    public function getPedido_id()
    {
        return $this->pedido_id;
    }



    public function setPedido_id($pedido_id)
    {
        $this->pedido_id = $pedido_id;

        return $this;
    }


    public function getEmpleado_id()
    {
        return $this->empleado_id;
    }



    public function setEmpleado_id($empleado_id)
    {
        $this->empleado_id = $empleado_id;

        return $this;
    }





    public function getEstado()
    {
        return $this->estado;
    }



    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }


    public function getDescripcion()
    {
        return $this->descripcion;
    }



    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }


    public function getFecha()
    {
        return $this->fecha;
    }



    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }


    public function getPrecio_total()
    {
        return $this->precio_total;
    }



    public function setPrecio_total($precio_total)
    {
        $this->precio_total = $precio_total;

        return $this;
    }




/* 
* Devuelve todos los pedidos ordenados de forma descendientes.
*
*/
    public function getAllPedidos()
    {
        $conn = database::getConnection();

        $query = " SELECT * FROM `Pedidos` ORDER BY `Pedidos`.`Ped_Fecha` DESC";

        $all_pedidos = mysqli_query($conn, $query);

        if (!$all_pedidos) {
            return false;
        }
        mysqli_close($conn);

        return $all_pedidos;
    }
    /* 
* 
*   Crea un pedido
*   Recibe: 
        - $array_confirmados : $_Session['Carrito']]
        - $descripcion : Descripcion del pedido
        - $precio_total : La suma del precio de todos los productos
*/
    public function CrearYConfirmar($array_confirmados, $descripcion, $precio_total)
    {
        /* Cogeremos el numero de registros maximo de la tabla pedidos para poder crear el ID de el nuevo pedido. */
        $registros = $this->getNumRegistros();
        $registros += 1;
        $pedido_id = "Pedido_0" . $registros;

        $this->setPedido_id($pedido_id);
        $this->setEmpleado_id($_SESSION['usuario_id']);
        $this->setEstado(0);
        $this->setDescripcion($descripcion);
        $this->setFecha(date("Y-n-j"));
        $this->setPrecio_total($precio_total);

        /* Insertaremos el el pedido en la tabla */
        $resultado_creacion_pedido = $this->crearPedido();
        /* Los errores de mysql son strings. 
        Si la query devuelve un string significa ha fallado. Si devuelve true significa que ha insertado el dato.
        */

        if (is_string($resultado_creacion_pedido) ) {
            return $resultado_creacion_pedido;
            
        } else {
            /*
            Si se ha insertado el contenido en la tabla Pedidos , pasaremos a insertar el contenido en la tabla "contenido" junto el Pedido_ID.            
            */
            $resultado = $this->creaContenidoPedido($array_confirmados, $pedido_id);
            
            if (is_string($resultado)) {  
                $this->borrarContenidoYPedido();         
                return $resultado;

            } else {
                /* Si finalmente se ha introducido el pedido y el contenido de este,se creara un Mensaje */
                $mensaje = new Mensaje();
                $mensaje->setContenido($this->getEmpleado_id());
                $mensaje_creado = $mensaje->createMensaje($this->getPedido_id());
                
                if ($mensaje_creado) {
                    return true;

                } else {
                    /* Si cualquiera de los procesos falla llamaremos a la funcion "borrarContenidoYPedido"  para borar tanto
                    el contenido como el pedido.*/
                    $this->borrarContenidoYPedido();                    
                    return $mensaje_creado;
                                    
                }
           
            }
         
        }

    }

    /* 
    *Devuelve el numero de filas de la tabla pedidos.
     */
    public function getNumRegistros()
    {
        $conn = database::getConnection();

        $query = 'SELECT * FROM Pedidos';
        $max_registros = mysqli_query($conn, $query);


        if (!$max_registros) {
            return false;
        }
        mysqli_close($conn);

        return $max_registros->num_rows;
    }

    /* 
    * Inserta en la tabla pedidos.
     */
    public function crearPedido()
    {
        $conn = database::getConnection();
        $query = "INSERT INTO `Pedidos` (`Pedido_ID`, `Empleado_ID`, `Ped_Estado`, `Ped_Descripcion`, `Ped_Fecha`, `Ped_Precio_total`)
        VALUES ('{$this->getPedido_id()}','{$this->getEmpleado_id()}', '{$this->getEstado()}', '{$this->getDescripcion()}', '{$this->getFecha()}',' {$this->getPrecio_total()}')";

        $resultado = mysqli_query($conn, $query);

        if (!$resultado) {
            return mysqli_error($conn);
        }
        mysqli_close($conn);


        return $resultado;
    }
    /* Inserta en la tabla Contenido */

    public function creaContenidoPedido($array_confirmados, $pedido_id)
    {
        $conn = database::getConnection();

        foreach ($array_confirmados  as $id => $cantidad) {

            $query = "INSERT INTO `Contiene` (`Pedido_ID`, `Prod_ID`, `Ped_Cantidad`) VALUES ('{$pedido_id}', '{$id}', '${cantidad}');";
            $contenido_introducido = mysqli_query($conn, $query);

            if (!$contenido_introducido) {
                return mysqli_error($conn);
            }
        }
        mysqli_close($conn);

        return $contenido_introducido;
    }
    /*
    * Borra pedidos y contenido.
    */

    public function borrarContenidoYPedido(){
        $conn = database::getConnection();

        $query="DELETE FROM `Pedidos` WHERE `Pedidos`.`Pedido_ID` = '{$this->getPedido_id()}'";
        $contenido_borrado = mysqli_query($conn, $query);
       
        if (!$contenido_borrado) {
            return false;
        }

        mysqli_close($conn);

        return $contenido_borrado;
    

    }
    /* Devuelve todos los detalles de un pedido gracias a la relacion de la tabla 'Pedido','Contenido' y 'Productos' */
    public function getFullPedidoDetalles($id_detalle){
        $conn = database::getConnection();

        $query="select * from Pedidos a inner join Contiene b on a.Pedido_ID = b.Pedido_ID inner join Productos c on b.Prod_ID = c.Prod_ID WHERE a.Pedido_ID='{$id_detalle}'";
        $detalle_pedido = mysqli_query($conn, $query);
       
        if (!$detalle_pedido) {
            return false;
        }

        mysqli_close($conn);

        return $detalle_pedido;
    

    }
    /* Cambia el estado del pedido a 1 para que se muestre como pedido aceptado. */

    public function aceptarPedido($id_pedido){
        $conn = database::getConnection();

        $query="UPDATE `Pedidos` SET `Ped_Estado` = '1' WHERE `Pedidos`.`Pedido_ID` = '{$id_pedido}';";
        $pedido_confirmado = mysqli_query($conn, $query);
       
        if (!$pedido_confirmado) {
            return false;
        }

        mysqli_close($conn);

        return $pedido_confirmado;
    

    }
    /* Cambia el estado del pedido a 2 para que se muestre como pedido rechazado. */

    public function rechazarPedido($id_pedido){
        $conn = database::getConnection();

        $query="UPDATE `Pedidos` SET `Ped_Estado` = '2' WHERE `Pedidos`.`Pedido_ID` = '{$id_pedido}';";
        $pedido_rechazado = mysqli_query($conn, $query);
       
        if (!$pedido_rechazado) {
            return false;
        }

        mysqli_close($conn);

        return $pedido_rechazado;
    

    }
    /* 
    * Devuelve la cantidad de pedidos que tenga  el estado en 0 es decir, pendiente.
     */
    public static function getPedidosPendientes(){
        $conn = database::getConnection();

        $query="SELECT * from `Pedidos` WHERE `Pedidos`.`Ped_Estado`= '0'";
        $pedidosPendientes = mysqli_query($conn, $query);

       
        if (!$pedidosPendientes) {
            return false;
        }

        mysqli_close($conn);

        return $pedidosPendientes->num_rows;
    

    }
    /* 
    * Devuelve la cantidad de pedidos que tenga  el estado en 1 es decir, confirmado.
     */
    public static function getPedidosConfirmados(){
        $conn = database::getConnection();

        $query="SELECT * from `Pedidos` WHERE `Pedidos`.`Ped_Estado`= 1";
        $pedidosConfirmados = mysqli_query($conn, $query);
       
        if (!$pedidosConfirmados) {
            return false;
        }

        mysqli_close($conn);

        return $pedidosConfirmados->num_rows;
    

    }
    /* 
    * Devuelve la cantidad de pedidos que tenga  el estado en 2 es decir, rechazado.
     */
    public static function getPedidosRechazados(){
        $conn = database::getConnection();

        $query="SELECT * from `Pedidos` WHERE `Pedidos`.`Ped_Estado`= 2";
        $pedidosRechazados= mysqli_query($conn, $query);
       
        if (!$pedidosRechazados) {
            return false;
        }

        mysqli_close($conn);

        return $pedidosRechazados->num_rows;
    

    }


    



    
}
