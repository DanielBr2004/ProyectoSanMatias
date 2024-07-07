<?php
session_start();

if(!isset($_SESSION['login']) || (isset($_SESSION['login']) && !$_SESSION['login']['permitido'])){ 
    header('Location:index.php');
}
//Usando .ENV
$host = "http://localhost/AppGranja/";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <link rel="icon" href="<?= $host ?>/img/icon.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <meta name="author" content="" />
        <title>Inicio</title>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= $host ?>/css/StylesPag.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= $host ?>/home.php">Granja San Matias</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= $host ?>/home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $host ?>/views/Usuarios/">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $host ?>/views/Productos/">Productos</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $host ?>/views/requerimientos">Requirimientos</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $host ?>/views/Kardex/">Inventario molino</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $host ?>/views/Kardex_huevos">Inventario Almacen de huevos</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Opciones</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Configuracion</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="http://localhost/AppGranja/controllers/login.controller.php?operacion=destroy">Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>