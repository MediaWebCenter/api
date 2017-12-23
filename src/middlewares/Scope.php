<?php
namespace src\middlewares;
use src\lib\ScopeLib;
use Psr\Container\ContainerInterface;



class Scope
{
    protected $container;
    //constructor 
    public function __construct(ContainerInterface $container){
          $this->container=$container;
    }
  //metodo magico __invoke para que entre directamente al llamar a la clase saltando el constructor  
    public function __invoke($request, $response,$next)  {
        //usamos getAttribute para coger la ruta y getName para acceder al nombre, es una propiedad privada
        $route = $request->getAttribute('route')->getName();
        //cogemos el container para inyectarlo en el objeto la libreria
        $container= $this->container;
        //inyectamos las dependencias del container
        $Scope= new ScopeLib($container);
        //enviamos la ruta al helper de la libreria
        $result=$Scope->getScope($route);
        //comprobamos el resultado para ejecutar el middleware
        if($result===TRUE){
            return $next($request, $response);
        }else{
            return $response->withJson(array('error'=>'No tiene permiso acceso a esta ruta'), 404);
        }
                          
             }
        
}