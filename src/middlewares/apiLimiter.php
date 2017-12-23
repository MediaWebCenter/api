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
      $limiterLib->apiLimiter();
    
     return $next($request, $response);
  }

}