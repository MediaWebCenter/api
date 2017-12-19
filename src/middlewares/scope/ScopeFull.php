<?php
namespace src\middlewares\scope;
use src\models;
use src\models\AuthModel;
use Psr\Container\ContainerInterface;
use src\lib\Auth;

class ScopeFull extends ScopeSelect
{
   
    public function __invoke($request, $response,$next){
        $inputVars=$request->getHeaders();
        $header=implode("", $inputVars["HTTP_AUTHORIZATION"]);
        $break = explode('Bearer ', $header);
        $decoded= Auth::GetData($break[1]);
        $auth= $this->container->get('AuthModel');
        $data=$auth->hasScope((int)$decoded->id);
        if($data["productos"]>=self::PERM_FULL){
            return $next($request, $response);
         }else{
            return $response->withJson(array('error'=>'No tiene permiso para acceder'), 404);
             }
        
            }
}