<?php
namespace src\models;

use PDO;
use FluentPDO;
use Exception;

abstract class BaseModel
{
    const FLUENTPDO = 'fluentpdo';
    const PDO = 'pdo';
    protected $conexion;
    
    
    function __construct($options)
    {
       try{
        $pdo = new PDO ("mysql:host=" . $options['host'] . ";dbname=" . $options['dbname'],  $options['user'],  $options['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        if($options['dblib'] === self::FLUENTPDO)
           $this->conexion = new FluentPDO($pdo); 
           else $this->conexion = $pdo;
       }
       catch (Exception $e){
             throw $e;
       }

    }
}