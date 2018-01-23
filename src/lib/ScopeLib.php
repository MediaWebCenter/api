<?php
namespace src\lib;
use src\models;
use src\models\AuthModel;
use Psr\Container\ContainerInterface;


class  ScopeLib {
    private  $container;
    //Creamos array de constantes con los roles y valores
    const API_ROLES = [
        'getAll'  =>0,
        'get'     =>1,
        'post'    =>2,
        'put'     =>3,
        'delete'  =>4,
        'full'    =>5
   ];

   //constructor 
   public function __construct(ContainerInterface $container){
    $this->container=$container;
}

public function getScope($route){

    if (empty($route)) {
        //No existe el nombre ruta no hay permisos, continua la ejecucion de la ruta
         return TRUE;
         
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
        //metemos el array de scopes del token
        $scopeToken=$token->scope;
        //Se consulta al modelo
        $auth= $this->container->get('AuthModel');
        //sacamos los scopes de la BBDD
        $checkBBDD=$auth->getScope($id);
        //comprobamos que existe en el array del container y de la BBDD
        if (array_key_exists($ruta, $checkBBDD) && array_key_exists($ruta, $scopeToken)) {
            //iteramos por las constantes de los permisos
            foreach (self::API_ROLES as $clave => $valor) {
                //Miramos si la clave coincide con el permiso asignado en la ruta
               if($clave === $permiso){
                   //miramos si el valor de la BBDD en permiso es mayor o igual al valor que pide la ruta
                  if($checkBBDD[$ruta] >= $valor){
                    //continuamos la ejecucion de la API
                      return TRUE;
                    }else{
                    //arrojamos el error cuando no tiene el permiso acceso la ruta
                    return FALSE;
                          }
                }
            }
        }else{
            //arrojamos error cuando se entra a una ruta sin permiso
            return FALSE;
            }
       
    }

}

}