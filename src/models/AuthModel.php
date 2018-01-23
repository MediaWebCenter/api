<?php
namespace src\models;



class AuthModel extends BaseModel
{
 private $table= 'accounts';
 private $data= 'accounts_info';
 public $response;
 
    function Autenticar(string $usuario)
    {
      try {
            //Select sobre usuarios para traer los valores
            $columnas=array($this->table.'.id',$this->table.'.username',$this->table.'.created' );
            //peticion de la tabla accounts los datos id, username y created
            $auth = $this->conexion->from($this->table)
                                    ->select(NULL)
                                    ->select($columnas)
                                    ->where('username',$usuario)
                                    ->fetch();  
                   //retornamos los campos consultados                   
                                     return $auth;
            
                  } catch (Exception $e) {
                        echo "Fallo: " . $e->getMessage();
                    }
                 }

    public function encriptarPayload(int $id){
      try {
            $campos=array($this->data.'.iat',$this->data.'.exp', $this->data.'.jti', $this->data.'.scope', $this->data.'.id', $this->data.'.xrequest'); 
            //peticion de la tabla account_info de los datos iat, exp y scope
            $valores = $this->conexion->from($this->data)
                                      ->select(NULL)
                                      ->select( $campos)
                                      ->where('id', $id)
                                      ->fetch(); 
            //retornamos los campos consultados
                                      return $valores;
             } catch (Exception $e) {
             echo "Fallo: " . $e->getMessage();
        }
      }

   public function setValues($set,$id){
         //update, metemos los valores del token en la BBDD
      try {
            return $this->conexion->update($this->data)
            ->set($set)
            ->where('id', $id)
            ->execute();  

      } catch (Exception $e) {
            echo "Fallo: " . $e->getMessage();
        }
   }

    public function getScope(int $id){
      try {
            $campos=array($this->data.'.scope');
            $valores = $this->conexion->from($this->data)
                                ->select(NULL)
                                ->select( $campos)
                                ->where('id', $id)
                                ->fetch(); 

              $deserializar= unserialize($valores->scope);
              return  $deserializar;

      } catch (Exception $e) {
            echo "Fallo: " . $e->getMessage();
        }
      

    }
     

};
