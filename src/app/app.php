<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require BASE_PATH . '/vendor/autoload.php';
require BASE_PATH . '/src/config/'.ENTORNO.'/config.php';

//session_start(); 

$dotenv = new Dotenv\Dotenv(BASE_PATH);
$dotenv->load();

$app = new \Slim\App(["settings" => $config]);
//Container-----------------------------------------------------------------------------
require BASE_PATH .'/src/container/container.php';
//Middlewares---------------------------------------------------------------------------
//require BASE_PATH .'/src/middlewares/Middlewares.php';

//Rutas---------------------------------------------------------------------------------
require BASE_PATH .'/src/routes/routes.php';

$app->run();