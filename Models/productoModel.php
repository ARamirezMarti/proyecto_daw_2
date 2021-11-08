<?php
require_once '../Database/db.php';

class Producto
{

    private $prod_id;
    private $prov_id;
    private $cat_id;
    private $nombre;
    private $descripcion;
    private $precio;



    public function getProd_id()
    {
        return $this->prod_id;
    }



    public function setProd_id($prod_id)
    {
        $this->prod_id = $prod_id;

        return $this;
    }


    public function getCat_id()
    {
        return $this->cat_id;
    }



    public function setCat_id($cat_id)
    {
        $this->cat_id = $cat_id;

        return $this;
    }


    public function getNombre()
    {
        return $this->nombre;
    }



    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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


    public function getPrecio()
    {
        return $this->precio;
    }



    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

     
    public function getProv_id()
    {
        return $this->prov_id;
    }

    public function setProv_id($prov_id)
    {
        $this->prov_id = $prov_id;

        return $this;
    }
     /* 
    * Devolvera todos los productos que tengan el campo enabled a  0 es decir que no esten deshabilitados
    */

    public function getAllEnabledProductos()
    {
        $conn = database::getConnection();
        $query = " SELECT * FROM `Productos` WHERE `Productos`.`Enabled` = 0";

        $all_productos = mysqli_query($conn, $query);

        if (!$all_productos) {
            return false;
        }
        mysqli_close($conn);

        return $all_productos;
    }

     /* 
    * Devolvera TODOS los productos
    */
    public function getAllProductos()
    {
        $conn = database::getConnection();
        $query = " SELECT * FROM `Productos` ";

        $all_productos = mysqli_query($conn, $query);

        if (!$all_productos) {
            return false;
        }
        mysqli_close($conn);

        return $all_productos;
    }

     /* 
    * Usada por el search bar. 
    * Devuelve los productos que tengan un nombre parecido al que se ha introducido en la search bar
    */
    public function getProductoBuscadosNombre($nombre)
    {
        $conn = database::getConnection();
        $query = " SELECT * FROM `Productos` WHERE `Prod_Nombre` LIKE '%{$nombre}%'";

        $all_productos = mysqli_query($conn, $query);

        if (!$all_productos) {
            return false;
        }
        mysqli_close($conn);

        return $all_productos;
    }

     /* 
    * Devuelve el producto por id
    */
    public function getProductoById($id)
    {
        $conn = database::getConnection();
        $query = " SELECT * FROM `Productos` WHERE Prod_ID={$id} ";


        $producto = mysqli_query($conn, $query);


        if (!$producto) {
            return false;
        }
        mysqli_close($conn);

        return $producto->fetch_object();
    }
     /* 
    * Deshabilita un producto en concreto por la id
    */
    public function deshabilitarProducto($id){
        $conn=database::getConnection();
        $query="UPDATE `Productos` SET `Enabled` = '1' WHERE `Productos`.`Prod_ID` = {$id};";
        $producto_deshabilitado = mysqli_query($conn,$query);
        
        if(!$producto_deshabilitado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $producto_deshabilitado;

    }

    /* 
    * Habilita un producto en concreto por la id
    */
    public function habilitarProducto($id){
        $conn=database::getConnection();
        $query="UPDATE `Productos` SET `Enabled` = '0' WHERE `Productos`.`Prod_ID` = {$id};";

        $producto_habilitado = mysqli_query($conn,$query);
        
        if(!$producto_habilitado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $producto_habilitado;

    }
    /* 
    * Inserta un producto nuevo en la base de datos.
    */
    public function crearProducto(){
        $conn=database::getConnection();
        $query="INSERT INTO `Productos` (`Prod_ID`, `Prov_ID`, `Cat_ID`, `Prod_Nombre`, `Prod_Descripcion`, `Prod_Precio`, `Enabled`) VALUES (NULL, '{$this->getProv_id()}', '{$this->getCat_id()}', '{$this->getNombre()}', '{$this->getDescripcion()}', '{$this->getPrecio()}', '0')";

        $proveedor_creado = mysqli_query($conn,$query);
        
        if(!$proveedor_creado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $proveedor_creado;

    }



  
}
