<?php
namespace src\models;
use src\lib\Response;

class MarcasModel extends BaseModel
{

    private $table= "marcas";
     
    function getAll()
    {
        $columnas=array('marcas.idhash','marcas.marca','marcas.producto','marcas.alternativa','marcas.created','marcas.updated_at');
        return $this->conexion->from($this->table)
                              ->select(NULL)
                              ->select($columnas)
                              ->fetchAll();
    }

    function findByIdHash(string $idHash)
    {
        $columnas=array('marcas.idhash','marcas.marca','marcas.producto','marcas.alternativa','marcas.created','marcas.updated_at');
         return $this->conexion->from($this->table)
                                ->select(NULL)
                                ->select($columnas)
                                ->where('idhash',$idHash)
                                ->fetch();
    }
    function insert(array $values)
    {

        try {
            $this->conexion->getPdo()->beginTransaction();
            $this->conexion->insertInto($this->table, $values)->execute();
            $id = $this->conexion->getPdo()->lastInsertId();
            $hash= md5($id);
            $values['idHash']=$hash;
            $this->conexion->update($this->table, $values, $id)->execute();
            $this->conexion->getPdo()->commit();
           
        } catch (Exception $e) {
            $this->conexion->getPdo()->rollBack();
            echo "Fallo: " . $e->getMessage();
        }
    
        //return $this->conexion->insertInto($this->table, $values)->execute();
    }

    function update(array $set, int $id)
    {
        return $this->conexion->update($this->table, $set, $id)->execute();
    }
 
    function delete(int $id)
    {
        return $this->conexion->deleteFrom($this->table, $id)->execute();
    }
   
}
