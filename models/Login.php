<?php

require_once 'Conexion.php';

class Colaborador extends Conexion{

    private $pdo;

    //Constructor
    public function __CONSTRUCT(){
        $this->pdo = parent::getConexion();
    }

      //Función para el login 
    public function login($params = []):array{
        try{
        $query = $this->pdo->prepare("call spu_colaboradores_login(?)");
        $query->execute(array($params['nomusuario']));
        return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
        die($e->getMessage());
        }
    }
        //Función para registrar al colaborador  
        public function add($params = []):int{
            $idcolaborador = null;
            try{
            $query = $this->pdo->prepare("call spu_colaboradores_registrar(?,?,?,?)");
            $query->execute(
                array(
                $params['idpersona'],
                $params['idrol'],
                $params['nomusuario'],
                password_hash($params['passusuario'], PASSWORD_BCRYPT)
                )
            );
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $idcolaborador = $row['idcolaborador'];
            }
            catch(Exception $e){
            $idcolaborador = -1;
            }
            return $idcolaborador;
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
