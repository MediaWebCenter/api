<?php

use src\controllers\HomeController;
use src\controllers\MarcasController;
use src\controllers\AuthController;
use src\middlewares\scope\ScopeSelect;
use src\middlewares\scope\ScopeAdd;
use src\middlewares\scope\ScopeUpdate;
use src\middlewares\scope\ScopeDelete;
use src\middlewares\scope\ScopeFull;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


// Redireccionamiento--------------------------------------------
$app->group('/', function()  use ($container){
    $this->get('', function (Request $request, Response $response) {
        $uri = $request->getUri() . 'v1'; 
        return $response->withRedirect( (string)$uri,301); 
      
        });
});

//API---------------------------------------------------------
$app->group('/v1', function () use ($container) {
  //Status la API---------------------------------------------
    $this->get('/status', HomeController::class . ':index');
//Productos--------------------------------------------------
    $this->group('/productos', function () use ($container) {
        $this->get('', MarcasController::class . ':index')->add(new ScopeSelect($container));
        $this->get('/{id}', MarcasController::class . ':show')->add(new ScopeSelect($container));
        $this->post('', MarcasController::class . ':create')->add(new ScopeAdd($container));
        $this->put('/{id}', MarcasController::class . ':update')->add(new ScopeUpdate($container));
        $this->delete('/{id}', MarcasController::class . ':delete')->add(new ScopeDelete($container));
               });
//Autentificacion-----------------------------------------------
     $this->group('/token', function () {
         //generamos el token con el controlador llamando a la funcion generateToken
       
        $this->post('',AuthController::class . ':generateToken');
       });
});



