<?php

require_once 'Conexion.php';

class Producto extends Conexion{

    private $pdo; 

    //Constructor
    public function __CONSTRUCT(){
        $this->pdo = parent::getConexion(); 
    }

    //Función para registrar el producto
    public function add($params = []):int{
        $idproducto = null;
        try{
            $query = $this->pdo->prepare("call spu_productos_registrar(?,?)");
            $query->execute(
                array(
                    $params['Producto'],
                    $params['descripcion']
                )
            );
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $idproducto = $row['idproducto'];
        }
        catch(Exception $e){
            $idproducto = -1;
        }
        return $idproducto; 
    }
        //Mostrará todas los tipos de productos de manera ordenada 
        public function getAll(){
            try{
                $tSQL = "SELECT idproducto, Producto FROM productos ORDER BY Producto";
                $consulta = $this->pdo->prepare($tSQL);
                $consulta->execute();
                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e){
                die($e->getMessage());
            }
        }
    
}