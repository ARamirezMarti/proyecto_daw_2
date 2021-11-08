<?php

class database
{


    public static function getConnection()
    {

         $conn = mysqli_connect('127.0.0.1', 'root', 'focamonje1', 'gec') or die("No se puede conectar con la base de datos"); 
      
        //$conn=mysqli_connect('db','root','pass','gec') or die("No se puede conectar con la  base de datos");


        mysqli_set_charset($conn, 'utf8mb4');

        if (!$conn) {
            echo "<br>Connection error" .  mysqli_connect_error();
        }
        return $conn;
    }
}
