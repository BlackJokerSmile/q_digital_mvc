<?php
    class Model {
        protected $pdo;

        public function __construct() {
            $this->pdo = \App::$pdo;
        }
    }
