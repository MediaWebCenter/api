<?php
namespace src\middlewares;
use Psr\Container\ContainerInterface;
/*
Ejemplo de Middleware de clase, se llama en /v1/mw routes.php linea 39

*/
class TestMW{
   
   protected $container;

   public function __construct(ContainerInterface $container){
      $this->container=$container;
   }

   public function __invoke($request, $response,$next){
      echo "Cagon diosla <br>";
      return $next($request,$response);
   }
  
}