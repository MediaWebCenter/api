<?php
namespace src\models;

class MarcasModel extends BaseModel
{

    
     
    function getAll()
    {
        $columnas=array('marcas.idhash','marcas.marca','marcas.producto','marcas.alternativa','marcas.created','marcas.updated_at');
        return $this->conexion->from('marcas')
                              ->select(NULL)
                              ->select($columnas)
                              ->fetchAll();
    }

    function findByIdHash(string $idHash)
    {
        $columnas=array('marcas.idhash','marcas.marca','marcas.producto','marcas.alternativa','marcas.created','marcas.updated_at');
         return $this->conexion->from('marcas')
                                ->select(NULL)
                                ->select($columnas)
                                ->where('idhash',$idHash)
                                ->fetch();
    }
    function insert(array $values)
    {

        try {
            $this->conexion->getPdo()->beginTransaction();
            $this->conexion->insertInto('marcas', $values)->execute();
            $id = $this->conexion->getPdo()->lastInsertId();
            $hash= md5($id);
            $values['idHash']=$hash;
            $this->conexion->update('marcas', $values, $id)->execute();
            $this->conexion->getPdo()->commit();
           
        } catch (Exception $e) {
            $this->conexion->getPdo()->rollBack();
            echo "Fallo: " . $e->getMessage();
        }
    
        //return $this->conexion->insertInto('marcas', $values)->execute();
    }

    function update(array $set, int $id)
    {
        return $this->conexion->update('marcas', $set, $id)->execute();
    }
 
    function delete(int $id)
    {
        return $this->conexion->deleteFrom('marcas', $id)->execute();
    }
    public function getId()
    {
     
          return $this->conexion->getPdo()->lastInsertId();
    }
}
