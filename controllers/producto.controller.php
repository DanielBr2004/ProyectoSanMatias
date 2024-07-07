<?php

require_once '../models/Productos.php';

//Instancia del objeto 
$producto = new Producto(); 

//Registrar Nuevo Producto
if(isset($_POST['operacion'])){

    switch($_POST['operacion']){
        case 'add':
            $datos = [
                "Producto"    => $_POST['Producto'],
                "descripcion"       => $_POST['descripcion']
            ];
            $idobtenido = $producto->add($datos);
            //Lo retornará como un JSON
            echo json_encode(["idproducto" => $idobtenido]);
            break;
    }
}
//Listar todos los tipos de productos
if(isset($_GET['operacion'])){

    switch($_GET['operacion']){
        case 'getAll':
            echo json_encode($producto->getAll());
            break;
    }
}