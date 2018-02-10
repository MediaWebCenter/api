<?php
namespace src\lib;
use src\models;
use src\models\ApiLimiterModel;
use Psr\Container\ContainerInterface;




class  apiLimiterLib 
{
    private  $requests;
    private  $container;

    public function __construct(ContainerInterface $container){
        $this->container=$container;
  }
    public function apiLimiter()  {
       //cogemos el token del container
       $token= $this->container->get('token');
       //llamamos al modelo de ApiLimiterModel
       $auth = $this->container->get('ApiLimiterModel');
       //enviamos el numero respuestas de count
       $count=$auth->seeRequest($token->username);
       //comprobamos si es un objeto lo que devuelve
      if(!is_object($count)){
          //Si esta vacio insertamos el primer registro en el contador
         $request=array (
            "username"=>$token->username,
            "count"=> 1
             );
          $insert=$auth->insertRequest($request);
          //Devolvemos verdadero para que siga el middleware
          return TRUE;
         
             }else{
                //comprobamos si tiene acceso a la zona por el limitador de request
               if ((int)$count->count<(int)$token->xrequest){
                        //pasamos a un numero entero
                        $integer=$count->count;
                        $i=(int)$integer;
                        $j=$i+1;
                        //Actualizamos el contador
                        $request=array (
                            "username"=>$token->username,
                            "count"=> $j
                            );
                    //insertamos en la base datos el nuevo valor
                    $insert=$auth->insertRequest($request);
                    //Devolvemos verdadero para que siga el middleware
                    return TRUE;
               
                }else{
                    //Devolvemos falso para que el middleware no autorice consultar la API
                    return FALSE;
                     }
            }
        }
}