<?php

require_once '../models/User.php';

//Instancia del objeto 
$persona = new Persona();

//Insertar persona  
if(isset($_POST['operacion'])){

    switch($_POST['operacion']){
        case 'add':
        $datos = [
            "apepaterno"    => $_POST['apepaterno'],
            "apematerno"    => $_POST['apematerno'],
            "nombres"       => $_POST['nombres'],
            "nrodocumento"  => $_POST['nrodocumento']
        ];
        $idobtenido = $persona->add($datos);
        echo json_encode(["idpersona" => $idobtenido]);
        break;
    }
    }

    //Mostrar registro encontrado por el numero de documento
    if(isset($_GET['operacion'])){

    switch($_GET['operacion']){
        case 'searchByDoc':
        echo json_encode($persona->searchByDoc(['nrodocumento' => $_GET['nrodocumento']]));
        break;
    }
    }

    //Mostrar registro de personas encontradas por el rol 
    if(isset($_GET['operacion'])){

    switch($_GET['operacion']){
        case 'searchByRol':
        echo json_encode($persona->searchByRol(['idrol' => $_GET['idrol']]));
        break;
    }
    }

    //Listar Nombre de Usuarios (kardex)
    if(isset($_GET['operacion'])){

        switch($_GET['operacion']){
            case 'getAll':
                echo json_encode($persona->getAll());
                break;
        }
    }

