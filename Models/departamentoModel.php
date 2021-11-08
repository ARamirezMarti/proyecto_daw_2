<?php
require_once DB_URL;

class Departamento{

    private $dep_id;
    private $nombre;
    private $telf;

     
    public function getDep_id()
    {
        return $this->dep_id;
    }

    
    
    public function setDep_id($dep_id)
    {
        $this->dep_id = $dep_id;

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


    /* Devuelve todos los departamentos.  */
    public function getDepartamentos(){
        $conn=database::getConnection();
        $query=" SELECT * FROM `Departamento`";
       
        $departamentos = mysqli_query($conn,$query);
        
        if(!$departamentos ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $departamentos;
    }

    /* Borra departamento de la base de datos */

    public function deleteDepartamento($id){
        $conn=database::getConnection();
        $query=" DELETE FROM `Departamento` WHERE `Departamento`.`Dep_ID` = {$id}";
       
        $deleted_departamento = mysqli_query($conn,$query);
        
        if(!$deleted_departamento ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $deleted_departamento;

    }
    /* Inserta un nuevo departamentos en la base de datos */
    public function addDepartamento(){
        $conn=database::getConnection();
        $query="INSERT INTO `Departamento` (`Dep_ID`, `Dep_Nombre`, `Dep_Telefono`) VALUES ('{$this->getDep_id()}', '{$this->getNombre()}', {$this->getTelf()}) ";
    
        $added_departamento = mysqli_query($conn,$query);
  
        if(!$added_departamento ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $added_departamento;

    }

}


?>