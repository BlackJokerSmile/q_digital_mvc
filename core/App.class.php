<?php
    class App {
        public static $current_controller;

        public static function run() {
            self::init();
            self::autoload();

            self::$current_controller = Router::get_current_controller();
        }

        private static function init(): void {
            define('DS', DIRECTORY_SEPARATOR);

            define('ROOT', getcwd() . DS);

            define('CORE_PATH', ROOT . 'core' . DS);
            define('CONTROLLERS_PATH', ROOT . 'controllers' . DS);
            define('MODELS_PATH', ROOT . 'models' . DS);
            define('VIEWS_PATH', ROOT . 'views' . DS);

            define('TEMPLATES_PATH', ROOT . 'templates' . DS);
            define('LAYOUT_PATH', TEMPLATES_PATH . 'layout.php');

            define('UTILS_PATH', ROOT . 'utils' . DS);

            require_once UTILS_PATH . 'getUrl.php';

            define('URI', getUrl());

            require_once CORE_PATH . 'Router.class.php';
            require_once CORE_PATH . 'Controller.class.php';

            require_once ROOT . 'routes.php';

            session_start();
        }

        private static function autoload(): void {
            spl_autoload_register(array(__CLASS__,'load'));
        }
        
        private static function load(string $classname): void {
            // Autoload app’s controller and model classes
        
            if (substr($classname, -10) == 'Controller'){
                // Controller
                require_once CONTROLLERS_PATH . $classname . '.class.php';
            } elseif (substr($classname, -5) == 'Model'){
                // Model
                require_once MODELS_PATH . $classname . '.class.php';
            }
        
        }
    }
