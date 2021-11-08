<?php
require_once DB_URL;
/* TODO:
 
    - No se si es necesario añadir la direccion y o todos los datos de direccion 
 
 */
class Proveedor
{

    private $prov_id;
    private $prov_dir_id;
    private $cif;
    private $nombre;
    private $telf;
    private $web;



    public function getProv_id()
    {
        return $this->prov_id;
    }


    public function setProv_id($prov_id)
    {
        $this->prov_id = $prov_id;

        return $this;
    }


    public function getProv_dir_id()
    {
        return $this->prov_dir_id;
    }



    public function setProv_dir_id($prov_dir_id)
    {
        $this->prov_dir_id = $prov_dir_id;

        return $this;
    }


    public function getCif()
    {
        return $this->cif;
    }



    public function setCif($cif)
    {
        $this->cif = $cif;

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


    public function getTelf()
    {
        return $this->telf;
    }



    public function setTelf($telf)
    {
        $this->telf = $telf;

        return $this;
    }


    public function getWeb()
    {
        return $this->web;
    }



    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /* 
    * Devolvera todos los proveedores de la BBDD
    */

    public function getAllProveedores()
    {
        $conn = database::getConnection();
        $query = " SELECT * FROM `Proveedor` p INNER JOIN `Prov_Direccion` d ON p.Direccion_ID=d.Direccion_ID ";


        $all_proveedores = mysqli_query($conn, $query);

        if (!$all_proveedores) {
            return false;
        }
        mysqli_close($conn);

        return $all_proveedores;
    }


    /* 
    * Deshabilitara el proveedor  y actualizara el campo "Enabled" de todos sus productos a 1 para deshabilitarlos tambien
    */

    public function deshabilitarProveedor($id){
        $conn=database::getConnection();
        $query="UPDATE `Proveedor` SET `Enabled` = '1' WHERE `Proveedor`.`Prov_ID` = {$id};";
       
        $proveedor_deshabilitado = mysqli_query($conn,$query);

        $query_deshabilitar = "UPDATE `Productos` SET `Enabled` = '1' WHERE `Prov_ID` = {$id};";
        $productos_desahabilitados = mysqli_query($conn,$query_deshabilitar);

        if(!$proveedor_deshabilitado || !$productos_desahabilitados ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $proveedor_deshabilitado;

    }

     /* 
    * Habilitara el proveedor  y actualizara el campo "Enabled" de todos sus productos a 0 para deshabilitarlos tambien
    */
    public function habilitarProveedor($id){
        $conn=database::getConnection();
        $query="UPDATE `Proveedor` SET `Enabled` = '0' WHERE `Proveedor`.`Prov_ID` = {$id};";

        $proveedor_habilitado = mysqli_query($conn,$query);
        $query_deshabilitar = "UPDATE `Productos` SET `Enabled` = '0' WHERE `Prov_ID` = {$id};";
        $productos_habilitados = mysqli_query($conn,$query_deshabilitar);
        
        if(!$proveedor_habilitado || !$productos_habilitados ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $proveedor_habilitado;

    }
    /* 
    * Insertara un nuevo proveedor en la BBDD
    */
    public function crearProveedor(){
        $conn=database::getConnection();
        $query="INSERT INTO `Proveedor` (`Prov_ID`, `Direccion_ID`, `Prov_Nombre`, `Prov_CIF`, `Prov_Telf`, `Prov_Web`, `Enabled`) VALUES (NULL, '{$this->getProv_dir_id()}', '{$this->getNombre()}', '{$this->getCif()}', '{$this->getTelf()}', '{$this->getWeb()}', '0');";

        $proveedor_creado = mysqli_query($conn,$query);
        
        if(!$proveedor_creado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $proveedor_creado;

    }
}
