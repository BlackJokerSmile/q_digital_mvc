<?php 
    class Controller {
        // show 404 page if action not found 
        public function __call($name, $arguments) {
            http_response_code(404);
            require TEMPLATES_PATH . 'page404.php';
            require LAYOUT_PATH;
        }
    }
