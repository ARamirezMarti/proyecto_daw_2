<?php
/* Eliminamos las variables de session y reenviamos al usuario al login.php */
session_start(); 
session_destroy(); 
sleep(2);
header('Location: login.php');
?>
