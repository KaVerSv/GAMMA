<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/PostController.php';
require_once 'src/controllers/GroupController.php';

class Routing{
    public static $routes;

    public static function get($url, $view){
        self::$routes[$url] = $view;
    }

    public static function post($url, $view){
        self::$routes[$url] = $view;
    }

    public static function run($url){
        $action = explode("/", $url)[0];

        // Warunek dla braku argumentów -> strona główna
        if (empty($action)) {
            $action = 'main'; // Domyślna ścieżka dla pustego adresu
        }
        
        if(!array_key_exists($action, self::$routes)){
            die("Wrong url!". $action);
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $object->$action();
    }
}