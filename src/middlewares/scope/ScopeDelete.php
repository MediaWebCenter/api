<?php
namespace src\middlewares\scope;
use src\models;
use src\models\AuthModel;
use Psr\Container\ContainerInterface;
use src\lib\Auth;

class ScopeDelete extends ScopeSelect
{
   
    public function __invoke($request, $response,$next){
        $inputVars=$request->getHeaders();
        $header=implode("", $inputVars["HTTP_AUTHORIZATION"]);
        $break = explode('Bearer ', $header);
        $decoded= Auth::GetData($break[1]);
        $auth= $this->container->get('AuthModel');
        $data=$auth->hasScope((int)$decoded->id);
        if($data["todo"]>=self::PERM_DELETE){
            return $next($request, $response);
         }else{
            return $response->withJson(array('error'=>'No tiene permiso para acceder'), 404);
             }
        
            }
}