<?php
namespace src\lib;
use src\models;
use src\models\ApiLimiterModel;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;



class  apiLimiterLib 
{
    private  $requests;
    private  $inmins;
    private  $container;

    public function __construct(ContainerInterface $container){
        $this->container=$container;
  }
    public function apiLimiter()  {
       //cogemos el token del container
       $token= $this->container->get('token');
       //llamamos al modelo de ApiLimiterModel
       $auth = $this->container->get('ApiLimiterModel');
        //enviamos el id de token para consulta en la BBDD el xrequest
       $data=$auth->seeRequest($token->id);
       //extraemos el limite que tiene el usuario de llamadas
       $requestLimit=$data->xrequest; 
       //insertamos el usuario
       $request=array (
        "username"=>$token->username,
        "count"=> 1
         );

        var_dump($request);
        die();
        $insert=$auth->insertRequest($request);
     
    
       
       }
   

    

}