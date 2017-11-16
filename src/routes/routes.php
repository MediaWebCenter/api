<?php

use \src\controllers\HomeController;
use \src\controllers\MarcasController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->group('/', function()  use ($container){
    $this->get('', function (Request $request, Response $response) {
        //Hacemos redireccionamiento a /v1
        // Revisar controlador admin/users:index
        //Ejemplo de redireccionamiento accediendo al container y con rutas con nombre
        //return $response->withRedirect( $this->container->router->pathFor('raizv1'));
      
        $uri = $request->getUri() . 'v1'; 
        return $response->withRedirect( (string)$uri,301); 
      
    });
});
    
//API---------------------------------------------------------------


$app->group('/v1', function () use ($container) {
    $this->get('', HomeController::class . ':index');

    $this->group('/productos', function () {
        $this->get('', MarcasController::class . ':index');
        $this->get('/{id}', MarcasController::class . ':show');
        $this->post('', MarcasController::class . ':create');
        $this->put('/{id}', MarcasController::class . ':update');
        $this->delete('/{id}', MarcasController::class . ':delete');
    });
});

