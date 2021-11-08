<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GEC:Gestion Empresarial de Compras</title>

    <script src="/js/main.js"></script>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <div id="header_title">
            <h1> GEC </h1>
        </div>
        
        <div id="header_logged">
            <p>Logged as: <?= $_SESSION['usuario_name'] ?> </p>
            <div class="menu_img_frame">
                <a href="/logout.php"><img  src="/assets/icons/logout.png" alt="Casa" ></a> 
            </div>
        </div>
      

        <!-- Todo:
        - Quitar la negacion del if session['admin']
        -->
        <?php if (isset($_SESSION['admin'])) : ?>

            <b>Administration Panel</b>
        <?php endif ?>


    </header>
    <hr>