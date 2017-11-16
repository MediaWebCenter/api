<?php
//Configuracion Modo Production


//Configuracion SLIM
$config['displayErrorDetails'] = false;
$config['addContentLengthHeader'] = false;
//$config['routerCacheFile'] = 'cache/routes.cache.php;

//Configuracion Database Modelos
$config['dblibmodels']= 'fluentpdo';              //fluentpdo || pdo
$config['db']['host']   = "localhost";
$config['db']['user']   = "izarwuqm_test";
$config['db']['dbname'] = "izarwuqm_test";

$config['force_https']='true';