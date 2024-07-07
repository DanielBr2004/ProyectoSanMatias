<?php
session_start();

require_once '../models/Login.php';

$colaborador = new Colaborador();

//Función para el login, donde se evalua si el usuario existe y si su clave esta encriptada y registrada
if(isset($_GET['operacion'])){

    switch($_GET['operacion']){
        case 'login':
            //Objeto que será devuelto que contendrá el acceso de los datos y sus atributos
            $login = [
                "permitido"     => false,
                "apepaterno"    => "",
                "apematerno"    => "",
                "nombres"       => "",
                "roles"         => "",
                "idcolaborador" => "",
                "status"        => "",
            ];

            $row = $colaborador->login(['nomusuario' => $_GET['nomusuario']]);

            if(count($row) == 0){
                $login["status"] = "No existe el Usuario";
            }else{
                //El Usuario Existe
                $claveEncriptada = $row[0]['passusuario'];
                $claveIngreso = $_GET['passusuario'];

                if(password_verify($claveIngreso, $claveEncriptada)){
                    $login["permitido"]     = true;
                    $login["apepaterno"]    = $row[0]["apepaterno"];
                    $login["apematerno"]    = $row[0]["apematerno"];
                    $login["nombres"]       = $row[0]["nombres"];
                    $login["roles"]         = $row[0]["roles"];
                    $login["idcolaborador"] = $row[0]["idcolaborador"];
                }else{
                    $login["status"] = "Contraseña Incorrecta"; 
                }
            }

            //Enviamos el objeto con el resultado
            $_SESSION['login'] = $login;
            echo json_encode($login);
            break;

        case 'destroy':
            session_unset();
            session_destroy();
            header('Location:http://localhost/AppGranja/');
            break;
    }
}

//Función de Registrar Colaborador, guardando el id
if(isset($_POST['operacion'])){

    switch($_POST['operacion']){
        case 'add':
            $datos = [
                "idpersona"     => $_POST['idpersona'],
                "idrol"         => $_POST['idrol'],
                "nomusuario"    => $_POST['nomusuario'],
                "passusuario"   => $_POST['passusuario']
            ];
            $idobtenido = $colaborador->add($datos);
            //Lo retonará en la vista como un JSON
            echo json_encode(["idcolaborador" => $idobtenido]);
            break;
    }
}

//Listar Nombre de Usuarios (kardex)
if(isset($_GET['operacion'])){

    switch($_GET['operacion']){
        case 'getAll':
            echo json_encode($colaborador->getAll());
            break;
    }
}
