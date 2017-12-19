<?php
namespace src\controllers;
use src\lib\Response;
use \Slim\Middleware\HttpBasicAuthentication\PdoAuthenticator;
use src\controllers\BaseController;
use src\lib\Auth;

final class AuthController extends BaseController
{

    public function generateToken($request, $response, $args)
    {
        
        try {
            $inputVars=$request->getHeaders();
            $usuario=implode("", $inputVars['PHP_AUTH_USER']);
            $auth = $this->container->get('AuthModel');
           //comprobamos que existe el usuario en la bbdd
            if ($data=$auth->Autenticar((string) $usuario)) {
                //recogemos el username
                $username=($data->username);
                $id=($data->id);
                //consultamos los payload que necesitamos
                $token=$auth->encriptarPayload($data->id);
                //comprobamos que el token no esta generado en el usuario anteriormente y grabamos en BBDD
                 if( empty($token->iat)  or empty($token->exp) or empty($token->jti) ){
                     //Sacamos la logica a una libreria para dejar el controlador lo mas limpio posible
                    //generamos el token con el username y los payload recogidos jti, exp, iat, scopes en lib/Auth
                    $generate= Auth::SignIn($token,$username); 
                    //decodificamos los valores en lib/Auth
                    $decoded= Auth::GetData($generate);
                    //generamos el array con iat, exp, jti
                    $set=array(
                    'iat' => $decoded->iat,
                    'exp' => $decoded->exp,
                    'jti' => $decoded->jti
                    ); 
                    //insertamos en la base datos
                    $data=$auth->setValues($set,$id);
                    //devolvemos el token en la respuesta a la consulta
                    return $response->withJson(array('Token'=>$generate), 200);
                 }else{
                    //si esta generado lo recuperamos los valores y lo regeneramos de la BBDD en lib/Auth
                    $generate= Auth::Restore($token,$username);
                    return $response->withJson(array('Token'=>$generate), 200);
                     }
                 } else {
                    return $response->withJson(array('error'=>'Credenciales incorrectas, consulte con el administrador'), 404);
                }
           
            
        } catch (Exception $e) {
            //lanzamos el error si no se produce correctamente el try
            $this->container->get('errorlog')->error($e->getMessage());
            return $response->withJson(array('error'=>'Ha ocurrido un error consulte al administrador'), 500);
        }
    }

    public function auth($request, $response, $args)
    {
       
       return $response->withJson(array('status'=>'auth...'), 200);
    }

}


 