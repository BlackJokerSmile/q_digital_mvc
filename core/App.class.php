<?php
    class App {
        public static $pdo;

        public static function run() {
            self::init();
            self::autoload();

            self::run_controller_action();
        }

        private static function init(): void {
            define('DS', DIRECTORY_SEPARATOR);

            define('ROOT', getcwd() . DS);

            define('UTILS_PATH', ROOT . 'utils' . DS);

            // include all util files
            require_once UTILS_PATH . 'utils.php';

            \Util\register_session();

            define('SESSION_USER', $_SESSION['session_user']);
            define('SESSION_USER_ID', $_SESSION['session_user_id']);
            
            define('CONFIG_PATH', ROOT . 'config' . DS);

            define('CORE_PATH', ROOT . 'core' . DS);
            define('CONTROLLERS_PATH', ROOT . 'controllers' . DS);
            define('MODELS_PATH', ROOT . 'models' . DS);
            define('VIEWS_PATH', ROOT . 'views' . DS);

            define('TEMPLATES_PATH', ROOT . 'templates' . DS);
            define('LAYOUT_PATH', TEMPLATES_PATH . 'layout.php');

            define('URI', \Util\get_url());

            $splitted_url = \Util\split_url();

            define('CONTROLLER', $splitted_url[0]);
            define('ACTION', $splitted_url[1]);
            define('ARGUMENTS', $splitted_url[2]);

            require_once CORE_PATH . 'Controller.class.php';
            require_once CORE_PATH . 'Model.class.php';

            self::$pdo = self::get_PDO();
        }

        private static function get_PDO(): \PDO {
            $cfg = parse_ini_file(CONFIG_PATH . 'pdo.cfg');

            if (!$cfg) {
                return new Exception('Cannot read given config file for database connection');
            }

            $dsn = sprintf(
                '%s:host=%s;dbname=%s',
                $cfg['DRIVER'],
                $cfg['HOST'],
                $cfg['DB_NAME']
            );

            $conn = new \PDO(
                $dsn,
                $cfg['DB_USER'],
                $cfg['DB_PASSWORD']
            );

            if (!$conn) {
                return new \Exception('Cannot connect to database with given settings');
            }

            return $conn;
        }

        private static function autoload(): void {
            spl_autoload_register(array(__CLASS__,'load'));
        }
        
        private static function load(string $classname): void {
            // Autoload app’s controller and model classes
        
            if (substr($classname, -10) == 'Controller') {
                // Controller
                $path = CONTROLLERS_PATH . $classname . '.class.php';
            } elseif (substr($classname, -5) == 'Model') {
                // Model
                $path =  MODELS_PATH . $classname . '.class.php';
            }
        
            if (file_exists($path)) {
                include_once $path;
            }
        }

        private static function run_controller_action(): void {
            if (CONTROLLER === '') {
                $controller_name = 'IndexController';
            } else {
                $controller_name = ucfirst(strtolower(CONTROLLER)) . "Controller";
            }

            if (class_exists($controller_name)) {
                $controller = new $controller_name();
            } else {
                $controller = new \Controller();
            }    

            $action_name = ACTION ?? 'main';

            $controller->$action_name();
        }
    }
