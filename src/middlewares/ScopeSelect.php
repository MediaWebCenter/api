<?php
namespace src\middlewares;
use src\models;
use src\models\AuthModel;
use src\lib\Auth;
use Psr\Container\ContainerInterface;


class Scope
{
   //Constantes de clase para definir los valores de los permisos
    protected $container;
    const PERM_FULL = 5;
    const PERM_DELETE = 4;
    const PERM_UPDATE = 3;
    const PERM_ADD = 2;
    const PERM_SELECT = 1;
    const PERM_NONE = 0;
   
//constructor 
    public function __construct(ContainerInterface $container){
          $this->container=$container;
           }
//metodo magico __invoke para que entre directamente al llamar a la clase saltando el constructor  
    public function __invoke($request, $response,$next) {
        
        
        }
        
    }