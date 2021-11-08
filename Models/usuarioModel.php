<?php


require_once DB_URL;

class Empleado
{

    private $empleado_id;
    private $dep_id;
    private $nombre;
    private $apellidos;
    private $password;
    private $telf;
    private $is_respon;



    public function getEmpleado_id()
    {
        return $this->empleado_id;
    }


    public function setEmpleado_id($empleado_id)
    {
        $this->empleado_id = $empleado_id;

        return $this;
    }


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

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        $this->password = $password;

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


    public function getIs_respon()
    {
        return $this->is_respon;
    }


    public function setIs_respon($is_respon)
    {
        $this->is_respon = $is_respon;

        return $this;
    }

    /* 
    * Nos devolvera el usuario de la base de datos
    */
    public function getUserbyID()
    {
        $conn = database::getConnection();
        $query = " SELECT * FROM `Empleado` WHERE `Empleado_ID` = {$this->getEmpleado_id()}";

        $resultado = mysqli_query($conn, $query);

        if (!$resultado) {
            $mysql_error = explode(' ', mysqli_error($conn));
            if ($mysql_error[0] == 'Unknown' && $mysql_error[1] == 'column') {

                return false;
            }
        }

        $user = $resultado->fetch_object();

        $this->setPassword($user->Emp_Password);
        $this->setEmpleado_id($user->Empleado_ID);
        $this->setNombre($user->Emp_Nombre);
        $this->setDep_id($user->Dep_ID);
        $this->setApellidos($user->Emp_Apellidos);
        $this->setTelf($user->Emp_Telf);
        $this->setIs_respon($user->Is_Emp_Respon);

        mysqli_close($conn);

        return $this;
    }

    /* 
    * Nos devolvera todos los empleados junto con al departamento que pertencen
    */
    public function getAllEmpleadosConDep(){
        $conn = database::getConnection();
        $query = " SELECT * FROM `Empleado` e inner join `Departamento` d on e.Dep_ID=d.Dep_ID";


        $empleados = mysqli_query($conn, $query);

        if (!$empleados) {
            return false;
        }
        mysqli_close($conn);

        return $empleados;
    }

    /* 
    * Insertara un nuevo usuario en la base de datos
    */

    public function crearUsuario(){
        $conn=database::getConnection();
        $query="INSERT INTO `Empleado` (`Empleado_ID`, `Dep_ID`, `Emp_Nombre`, `Emp_Apellido`, `Emp_Password`, `Emp_Telf`, `Is_Emp_Respon`) VALUES ('{$this->getEmpleado_id()}', '{$this->getDep_id()}', '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getPassword()}', {$this->getTelf()}, '0');";
    
        $usuario_creado = mysqli_query($conn,$query);
  
        if(!$usuario_creado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $usuario_creado;

    }
    /* 
    * Cambiara el campo Is_Emp_Respon a 1 para que el usuario sea considerado administrador
    */

    public function promocionarEmpleado($id){
        $conn=database::getConnection();
        $query="UPDATE `Empleado` SET `Is_Emp_Respon` = '1' WHERE `Empleado`.`Empleado_ID` = {$id}";
    
        $usuario_promocionado = mysqli_query($conn,$query);
  
        if(!$usuario_promocionado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $usuario_promocionado;

    }
    /* 
    * Cambiara el campo Is_Emp_Respon a 0 para que el usuario sea considerado usuario
    */
    public function degradarEmpleado($id){
        $conn=database::getConnection();
        $query="UPDATE `Empleado` SET `Is_Emp_Respon` = '0' WHERE `Empleado`.`Empleado_ID` = {$id}";
    
        $usuario_Degradado = mysqli_query($conn,$query);
  
        if(!$usuario_Degradado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $usuario_Degradado;

    }

    /* 
    * Eliminara el usuario de la BBDD
    */
    public function deleteEmpleado($id){
        $conn=database::getConnection();
        $query=" DELETE FROM `Empleado` WHERE `Empleado`.`Empleado_ID` = {$id}";
       
        $deleted_empleado = mysqli_query($conn,$query);
        
        if(!$deleted_empleado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $deleted_empleado;

    }

    /* 
    * Modificara los datos del empleado
    */
    public function updateEmpleado(){
        $conn=database::getConnection();
        $query=" UPDATE `Empleado` SET 
        `Emp_Password` = '{$this->getPassword()}',
        `Emp_Nombre` = '{$this->getNombre()}',
        `Emp_Apellido` = '{$this->getApellidos()}',
        `Emp_Telf`={$this->getTelf()},
        `Dep_ID`='{$this->getDep_id()}' WHERE `Empleado`.`Empleado_ID` = {$this->getEmpleado_id()}";
       
        $deleted_empleado = mysqli_query($conn,$query);
        
        if(!$deleted_empleado ){
            return false;
          
        }
        mysqli_close($conn);
       
        return $deleted_empleado;

    }



}
