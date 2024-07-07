<?php

require_once 'Conexion.php';

    class Persona extends Conexion{

    private $pdo; 

    //Constructor
    public function __CONSTRUCT(){
        $this->pdo = parent::getConexion();
    }

    //Función para registrar a la persona devolviendo su id 
    public function add($params = []):int{
        $idgenerado = null;
        try{
        $query = $this->pdo->prepare("call spu_personas_registrar(?,?,?,?)");
        $query->execute(
            array(
            $params['apepaterno'],
            $params['apematerno'],
            $params['nombres'],
            $params['nrodocumento']
            )
        );  
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $idgenerado = $row['idpersona'];
        }
        catch(Exception $e){
        $idgenerado = -1;
        }
        return $idgenerado;
    }

    //Función para buscar a la persona por el numero de documento 
    public function searchByDoc($params = []):array{
        try{
        $query = $this->pdo->prepare("call spu_colaborador_buscar_dni(?)");
        $query->execute(
            array($params['nrodocumento'])
        );

        return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
        die($e->getMessage());
        }
    }

    //Función para buscar las personas con el mismo rol 
    public function searchByRol($params = []):array{
        try{
        $query = $this->pdo->prepare("call spu_persona_buscar_por_rol(?)");
        $query->execute(
            array($params['idrol'])
        );
        return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
        die($e->getMessage());
        }
    }

        //Función para mostrar los nombres de Usuarios
    public function getAll(){
        try{
        $tSQL = "SELECT idcolaborador, nomusuario FROM colaboradores ORDER BY nomusuario";
        $consulta = $this->pdo->prepare($tSQL);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch(Exception $e){
        die($e->getMessage());
        }
    }
}

