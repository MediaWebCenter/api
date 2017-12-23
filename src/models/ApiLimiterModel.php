<?php
namespace src\models;

class ApiLimiterModel extends BaseModel
{
    private $table= 'accounts_info';
    private $request= 'request';

    function seeRequest(int $id){
        try {
            $columnas=array($this->table.'.xrequest');
            $auth = $this->conexion->from($this->table)
            ->select(NULL)
            ->select($columnas)
            ->where('id',$id)
            ->fetch();  
            //retornamos los campos consultados                   
                return $auth;

            }catch (Exception $e) {
                echo "Fallo: " . $e->getMessage();
            }
     }
//insertamos en la tabla el usuario
    function insertRequest( $values){
       return $this->conexion->insertInto($this->request, $values)->execute();
    }
//upadate de la consultas

    

}