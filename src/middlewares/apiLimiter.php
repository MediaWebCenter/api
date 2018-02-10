<?php
namespace src\middlewares;
use Psr\Container\ContainerInterface;
use src\lib\apiLimiterLib;
 
class apiLimiter{

    public function __construct(ContainerInterface $container){
        $this->container=$container;
  }

  public function __invoke($request, $response,$next)  {
      //cogemos el container para inyectarlo en el objeto la libreria
      $container= $this->container;
      //inyectamos las dependencias del container
      $limiterLib= new apiLimiterLib($container);
      //llamamos al metodo creado
      $res=$limiterLib->apiLimiter();
      if($res===TRUE){
       //Dejamos que pase el middleware
        return $next($request, $response);
     }else{
         //no damos permiso para continuar ejecutando la API
         return $response->withJson(array('warning'=>'Terminó su sesión, ha excedido el límite consultas a la API'), 404);
      }
    }

}