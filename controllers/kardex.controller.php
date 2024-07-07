<?php

require_once '../models/kardex.php';

//Instancia del objeto 
$kardex = new Kardex();

//Registrar El Kardex
if(isset($_POST['operacion'])){

    switch($_POST['operacion']){
        case 'add':
            $datosEnviar = [
                "idcolaborador"     => $_POST['idcolaborador'],
                "idproducto"        => $_POST['idproducto'],
                "tipomovimiento"    => $_POST['tipomovimiento'],
                "cantidad"          => $_POST['cantidad']
            ];
            //Retornará un booleano 
            $status = $kardex->add($datosEnviar);
            //Se envía el valor del status como un booleano
            echo json_encode(["estado" => $status]);
            break;
    }
}

//Mostrar el stock actual por el producto que se seleccione 
if(isset($_GET['operacion'])){

    switch($_GET['operacion']){
        case 'mostrarStockActual':
            echo json_encode($kardex->mostrarStockActual(['idproducto' => $_GET['idproducto']]));
            break;
    }
}


