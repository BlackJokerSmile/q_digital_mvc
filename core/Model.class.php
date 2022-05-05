<?php
    class Model {
        protected $pdo;

        public function __construct() {
            $this->pdo = $this->getPDO();
        }

        public function getPDO(): \PDO {
            $cfg = $this->getConfigPDO();

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

        protected function getConfigPDO() {
            return parse_ini_file(CONFIG_PATH . 'pdo.cfg');
        }
    }
