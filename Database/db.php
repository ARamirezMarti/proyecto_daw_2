<?php

class database
{


    public static function getConnection()
    {
        //TODO: CAMBIAR LA PASS DE MYSQL
         /* IMPORTANTE: 
        * Descomentar la linia inferior si queremos acceder a la base de datos local
        */
        $conn = mysqli_connect('127.0.0.1', 'root', 'focamonje1', 'gec') or die("No se puede conectar con la base de datos"); 
      
        /* IMPORTANTE: 
        * Descomentar la linia inferior si queremos acceder a la base de datos creada por docker-compose
        */
        //$conn=mysqli_connect('database','root','pass','gec') or die("No se puede conectar con la  base de datos");


        mysqli_set_charset($conn, 'utf8_general_ci');

        if (!$conn) {
            echo "<br>Connection error" .  mysqli_connect_error();
        }
        return $conn;
    }
}
