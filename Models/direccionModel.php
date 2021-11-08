<?php


class Direccion
{

    private $dir_id;
    private $calle;
    private $pais;
    private $cod_postal;
    private $provincia;
    private $ciudad;



    public function getDir_id()
    {
        return $this->dir_id;
    }


    public function setDir_id($dir_id)
    {
        $this->dir_id = $dir_id;

        return $this;
    }


    public function getCalle()
    {
        return $this->calle;
    }


    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }


    public function getPais()
    {
        return $this->pais;
    }


    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }


    public function getCod_postal()
    {
        return $this->cod_postal;
    }


    public function setCod_postal($cod_postal)
    {
        $this->cod_postal = $cod_postal;

        return $this;
    }


    public function getProvincia()
    {
        return $this->provincia;
    }


    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }


    public function getCiudad()
    {
        return $this->ciudad;
    }


    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /* 
    Inserta una nueva direccion en la base de datos
    */

    public function crearDireccion(){
        $conn=database::getConnection();
        $query="INSERT INTO `Prov_Direccion` (`Direccion_ID`, `Dir_Calle`, `Dir_Pais`, `Dir_Cod_Postal`, `Dir_Provincia`, `Dir_Ciudad`) VALUES (NULL, '{$this->getCalle()}', '{$this->getPais()}', {$this->getCod_postal()}, '{$this->getProvincia()}', '{$this->getCiudad()}')";

        $direccion_creada = mysqli_query($conn,$query);
        
        if(!$direccion_creada ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $direccion_creada;

    }

    /* Devuelve el ID de una direccion por codigo postal y calle. */
    public function getIdDireccion(){
        $conn=database::getConnection();
        $query="SELECT * FROM `Prov_Direccion` WHERE `Dir_Calle` = '{$this->getCalle()}' AND `Dir_Cod_Postal` = {$this->getCod_postal()}";

        $direccion = mysqli_query($conn,$query);
        
        if(!$direccion ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $direccion;

    }
    
}
