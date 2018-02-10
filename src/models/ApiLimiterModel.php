<?php
namespace src\models;

class ApiLimiterModel extends BaseModel
{
    private $table= 'accounts_info';
    private $request= 'request';
 

function seeRequest( $username){
        try {
            //cogemos el valor que nos interesa de la tabla, la cuenta visitas
            $columnas=array($this->request.'.count');
            $count = $this->conexion->from($this->request)
            ->select(NULL)
            //metemos los campos a seleccionar de la tabla
            ->select($columnas)
            //Primer where nos busca por username
            ->where('username',$username)
            //Segundo where es como un AND para unir el tiempo
            ->where('created >= date_sub(NOW(), interval 1 HOUR)')
            //usamos el orderby DESC por id para coger el ultimo id
            ->orderBy('id DESC')
            //arrojamos los resultados de la busqueda
            ->fetch();
            //retornamos los campos consultados  
            return $count;

            }catch (Exception $e) {
               echo "Fallo: " . $e->getMessage();
            }
     }
  
//insertamos en la tabla el usuario
    function insertRequest( $values){
        //upadate de la consultas
       return $this->conexion->insertInto($this->request, $values)->execute();
    }

}