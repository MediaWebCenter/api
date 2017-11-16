<?php
namespace src\controllers;
use Psr\Container\ContainerInterface;


abstract class BaseController{
    
    protected $container;
    //protected $scope;
    
        // constructor receives container instance
       public function __construct($container) {
           $this->container = $container;
           //$this->scope=array();
       }
       /*
       public function setScope(array $scope){
          $this->scope['area']=$scope['area'];
          $this->scope['scope']=$scope['scope'];
       }
       */
      
          

}