
<?php
require_once DB_URL;


class Categorias{
    private $Cat_ID;
    private $Nombre;

    
    public function getCat_ID()
    {
        return $this->Cat_ID;
    }

    public function setCat_ID($Cat_ID)
    {
        $this->Cat_ID = $Cat_ID;

        return $this;
    }


    public function getNombre()
    {
        return $this->Nombre;
    }

    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;

        return $this;
    }
    /* Devuelve todas las categorias */
    public function getAllCategorias(){
        $conn = database::getConnection();
        $query = " SELECT * FROM `Categoria`";


        $all_categorias = mysqli_query($conn, $query);

        if (!$all_categorias) {
            return false;
        }
        mysqli_close($conn);

        return $all_categorias;
    }

   
}