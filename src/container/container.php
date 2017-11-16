<?php
use \src\models\MarcasModel;

$container = $app->getContainer();

//Creacion array opciones de conexion a la base de datos
$config=$container['settings'];
$pass="";
if(ENTORNO === 'development')  $pass=getenv("DB_PASS_DEV"); 
   else $pass=getenv("DB_PASS_PRO");
$options=array(
    'dblib' => $config['dblibmodels'],
    'host'  => $config['db']['host'],
    'dbname'=> $config['db']['dbname'],
    'user'  => $config['db']['user'],
    'pass'  => $pass
);

// Modelos de datos
$container['MarcasModel'] = function ($container) use($options){
    try{
     return new MarcasModel($options);
    }catch (Exception $e){
        throw $e;
    }
};


