<?php
namespace src\controllers;
use src\lib\Response;
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;
use src\controllers\BaseController;

final class AuthController extends BaseController
{

    public function show($request, $response, $args)
    {
        
        try {
            $inputVars=$request->getHeaders();
            //$contrasena= implode("", $inputVars[' PHP_AUTH_PW']);
            $usuario=implode("", $inputVars['PHP_AUTH_USER']);

            $auth = $this->container->get('AuthModel');
           
            if ($data=$auth->Autenticar((string) $usuario)) {
                
                    return $response->withJson(array('Token'=>$data), 200);
                } else {
                    return $response->withJson(array('error'=>'Credenciales incorrectas, consulte con el administrador'), 404);
                }
           
            
        } catch (Exception $e) {
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }

    public function auth($request, $response, $args)
    {
       
       return $response->withJson(array('status'=>'auth...'), 200);
    }

}


 