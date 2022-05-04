<?php
    class Router {
        protected static $routes;
        
        public static function route(array $_routes) {
            self::$routes = $_routes;
        }

        public static function get_current_controller(): \Controller {
            $controller_name = self::$routes[URI];
            
            $controller = new $controller_name();

            return $controller;
        }
    }