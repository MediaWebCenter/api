<?php
namespace src\middlewares;
use src\models;
use Psr\Container\ContainerInterface;
use src\models\ApiLimiterModel;
use src\lib\apiLimiterLib;
 
class apiLimiter{

    public function __construct(ContainerInterface $container){
        $this->container=$container;
  }

  public function __invoke($request, $response,$next)  {
    
    $token= $this->container->get('token');
    apiLimiterLib::apiLimiter($token);
   
        return $next($request, $response);
  }

}