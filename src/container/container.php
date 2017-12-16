<?php
use \src\models\MarcasModel;
use \src\models\AuthModel;
use \src\middlewares;
use \src\middlewares\AuthMiddleware;
use \src\middlewares\TestMW;

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



//marcas
$container['MarcasModel'] = function ($container) use($options){
    try{
     return new MarcasModel($options);
    }catch (Exception $e){
        throw $e;
    }
};
//auth container
$container['AuthModel'] = function ($container) use($options) {
    try{
        return new AuthModel($options);
    }catch (Exception $e){
        throw $e;
    }
    
};
//AuthMiddleWare

$container['AuthMiddleware']= function ($container) use($options){
     return new AuthMiddleware($container);
};
$container['HttpBasicAuthentication']= function ($container) use($options){
    return new \Slim\Middleware\HttpBasicAuthentication($container);
};
$container['TestMW']= function ($container){
      return new TestMW($container);
    };

$container["token"] =function ($container) {
        return new StdClass;
   };

//PDO conexion para autenticar usuarios para la obtencion del token
$container['pdo'] = function ($container)  use($options) {
    //$container['logger']->addInfo("DSN=", array('dsn' => DSN));
    $pdo = new PDO ("mysql:host=" . $options['host'] . ";dbname=" . $options['dbname'], $options['user'], $options['user']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
};




//Sistema de Plantilla TWIG
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(BASE_PATH .'/public/views', [
        'cache' => false
    ]);
    
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    //$view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new Slim\Views\TwigExtension(
        
        $container->router, 
        $request->getUri()
    ));
    //añade una variable global a las vistas
   /* $view->getEnvironment()->addGlobal('auth',[
        'issignin' => $container['auth']->isSignIn()
        
    ]);  */ 
    
    return $view;
};




