<?php
namespace src\models;

class ApiLimiterModel extends BaseModel
{
    private $table= 'accounts_info';
    private $request= 'request';
    private $inmins;

function seeRequest( $username){
        try {
           
            $columnas=array($this->request.'.count');
            $count = $this->conexion->from($this->request)
            ->select(NULL)
            ->select($columnas)
            ->where('username',$username)
            ->where('created >= date_sub(NOW(), interval 1 HOUR)')
            ->orderBy('id DESC')
            ->fetch();
            //retornamos los campos consultados  
            return $count;

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