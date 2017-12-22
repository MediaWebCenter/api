<?php

use src\controllers\HomeController;
use src\controllers\MarcasController;
use src\controllers\AuthController;
use src\middlewares\Scope;
use src\middlewares\apiLimiter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/*********************** Redireccionamiento *****************************************/

$app->group('/', function()  use ($container){
    $this->get('', function (Request $request, Response $response) {
        $uri = $request->getUri() . 'v1'; 
        return $response->withRedirect( (string)$uri,301); 
      
        });
});

/*********************** API *****************************************/
$app->group('/v1', function () use ($container) {

/*********************** Status la API  *****************************************/
       //ruta para comprobar el estado de la API con token
    $this->get('', HomeController::class . ':index');
      //ruta para comprobar el estado de la API sin token para no registrados
    $this->get('/status', HomeController::class . ':index');
   

/*********************** Rutas de Productos en la API  *****************************************/
       //hay que poner el $container para pasar los valores a los middlewares
    $this->group('/productos', function () use ($container) {
        //en las rutas se pone productos para comprobar en el array serializado de accounts_info
        //el primer valor del array que nos da el scope de lectura, escritura,update y delete general
        $this->get('', MarcasController::class . ':index')->setName("productos.getAll");
        $this->get('/{id}', MarcasController::class . ':show')->setName("productos.get");
        $this->post('', MarcasController::class . ':create')->setName("productos.post");
        $this->put('/{id}', MarcasController::class . ':update')->setName("productos.put");
        $this->delete('/{id}', MarcasController::class . ':delete')->setName("productos.delete");
               });
               
/*********************** Autentificacion  *****************************************/
     $this->group('/token', function () {
         //generamos el token con el controlador llamando a la funcion generateToken
        $this->post('', AuthController::class . ':generateToken');
       });
})->add(new Scope($container))->add(new apiLimiter($container));



