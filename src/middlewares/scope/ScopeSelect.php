<?php
namespace src\middlewares\scope;
use src\models;
use src\models\AuthModel;
use src\lib\Auth;
use Psr\Container\ContainerInterface;


class ScopeSelect
{
   
    protected $container;
    const PERM_FULL = 5;
    const PERM_DELETE = 4;
    const PERM_UPDATE = 3;
    const PERM_ADD = 2;
    const PERM_SELECT = 1;
    const PERM_NONE = 0;
   

    public function __construct(ContainerInterface $container){
          $this->container=$container;
           }
     
    public function __invoke($request, $response,$next) {
        
        $inputVars=$request->getHeaders();
        $header=implode("", $inputVars["HTTP_AUTHORIZATION"]);
        $break = explode('Bearer ', $header);
        $decoded= Auth::GetData($break[1]);
        $auth= $this->container->get('AuthModel');
        $data=$auth->hasScope((int)$decoded->id);
        if($data["productos"]>=self::PERM_SELECT){
            return $next($request, $response);
           }else{
            return $response->withJson(array('error'=>'No tiene permiso para acceder'), 404);
            }
        }
        
    }