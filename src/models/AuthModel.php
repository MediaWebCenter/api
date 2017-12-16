<?php
namespace src\models;
use src\lib\Auth;


class AuthModel extends BaseModel
{
 private $table= 'accounts';
 private $data= 'accounts_info';
 public $response;
 
    function Autenticar(string $usuario)
    {
      try {
            $this->conexion->getPdo()->beginTransaction();
            $columnas=array($this->table.'.id',$this->table.'.username',$this->table.'.created' );

            $auth = $this->conexion->from($this->table)
                                    ->select(NULL)
                                    ->select($columnas)
                                    ->where('username',$usuario)
                                    ->fetch();  
                                   
            $campos=array($this->data.'.iat',$this->data.'.exp', $this->data.'.jti', $this->data.'.scope'); 

            $valores = $this->conexion->from($this->data)
                                      ->select(NULL)
                                      ->select( $campos)
                                      ->where('id', $auth->id)
                                      ->fetch(); 

            $deserializar= unserialize($valores->scope);
                                         
             if(is_object($auth)){
                         $token= Auth::SignIn([
                               'id'=>$auth->id,
                               'username'=>$auth->username,
                               'scope'=>$deserializar
                            ]); 
            

            $decoded= Auth::GetData($token);

            $set=array(
                  'iat' => $decoded->iat,
                  'exp' => $decoded->exp,
                  'jti' => $decoded->jti
                  );

            if( empty($valores->iat)  or empty($valores->exp) or empty($valores->jti) ){
                  $this->conexion->update($this->data)
                                  ->set($set)
                                  ->where('id', $auth->id)
                                  ->execute();  

                                  $data=$token;
                     }else{
                        $tokenRes= Auth::Restore([
                              'iat'=>$valores->iat,
                              'exp'=>$valores->exp,
                              'jti'=>$valores->jti,
                              'id'=>$auth->id,
                              'username'=>$auth->username,
                              'scope'=>$deserializar
                             ]); 

                                  $data=$tokenRes;
            
                              }       
                        
                         $this->conexion->getPdo()->commit();
                         return $data;
                   }


                  } catch (Exception $e) {
                        $this->conexion->getPdo()->rollBack();
                        echo "Fallo: " . $e->getMessage();
                    }
                

    }

    public function hasScope(int $id){

      $campos=array($this->data.'.scope');

      $valores = $this->conexion->from($this->data)
                                ->select(NULL)
                                ->select( $campos)
                                ->where('id', $id)
                                ->fetch(); 

              $deserializar= unserialize($valores->scope);
              return  $deserializar;

    }
     

};
