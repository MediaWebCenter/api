<?php
namespace src\middlewares;
use src\models;
use src\models\AuthModel;
use src\lib\Auth;
use Psr\Container\ContainerInterface;


class Scope
{
   //Constantes de clase para definir los valores de los permisos poner en array 
    protected $container;
    const DEFAULT_ROLES = ['getAll'=>0, 'get'=>1,'post'=>2,'put'=>3,'delete'=>4,'full'=>5];

  
   
//constructor 
    public function __construct(ContainerInterface $container){
          $this->container=$container;
           }
//metodo magico __invoke para que entre directamente al llamar a la clase saltando el constructor  
    public function __invoke($request, $response,$next)  {
        //usamos getAttribute para coger la ruta y getName para acceder al nombre, es una propiedad privada
        $route = $request->getAttribute('route')->getName();
        //Si esta vacia la ruta lanzamos un error
        if (empty($route)) {
            //No existe el nombre ruta no hay permisos, continua la ejecucion de la ruta
            return $next($request, $response);
        }else{
            //existe el nombre de la ruta se comprueba los permisos de acceso a dicha ruta
            $subcadena = strpos ($route, '.'); 
            //se parte la cadena y se coge la posicion inicial antes del . que la divide para la 1 parte
            $ruta = substr ($route, 0,($subcadena));
            //se parte la segunda parte la cadena y se coge el final para el permiso
            $permiso = substr ($route,($subcadena)+1);
            //obtenemos el token del container
            $token= $this->container->get('token');
            //metemos la variable id del token
            $id= $token->id;
            $scopes= $token->scope;
            //Se consulta al modelo
            $auth= $this->container->get('AuthModel');
            $checkBBDD=$auth->getScope($id);
            //metemos el array de scopes
            $scopeToken=$token->scope;
            //comprobamos que existe en el array del container y de la BBDD
            if (array_key_exists($ruta, $checkBBDD) && array_key_exists($ruta, $scopeToken)) {
                //iteramos por las constantes de los permisos
                foreach (self::DEFAULT_ROLES as $clave => $valor) {
                    //Miramos si la clave coincide con el permiso asignado en la ruta
                   if($clave === $permiso){
                       //miramos si el valor del token en permiso es mayor o igual al valor que pide la ruta
                     if($token->scope->productos >= $valor){
                        //continuamos la ejecucion de la API
                        return $next($request, $response);
                      }else{
                        //arrojamos el error cuando no tiene el permiso
                        return $response->withJson(array('error'=>'No tiene permiso acceso a esta ruta'), 404);
                         }
                      }
                }
            }else{
                //arrojamos error cuando se entra a una ruta sin permiso
                return $response->withJson(array('error'=>'No tiene permiso acceso a esta ruta'), 404);
            }
           
        }
     
        }
        
    }