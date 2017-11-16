<?php
//Configuracion Modo Development


//Configuracion SLIM
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
//$config['routerCacheFile'] = 'cache/routes.cache.php;

//Configuracion Database Modelos
$config['dblibmodels']= 'fluentpdo';              //fluentpdo || pdo
$config['db']['host']   = "localhost";
$config['db']['user']   = "root";
$config['db']['dbname'] = "catalanes";

$config['force_https']='false';