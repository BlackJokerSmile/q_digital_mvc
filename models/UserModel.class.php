<?php
    class UserModel extends Model {
        public function createUser(string $user_login, string $user_password): bool {
            $sth = $this->pdo->prepare('INSERT INTO `users`(`login`, `password`) VALUES (:login, :password)');
        
            $is_inserted = $sth->execute([
                'login' => htmlspecialchars($user_login),
                'password' => password_hash($user_password, PASSWORD_BCRYPT)
            ]);
            
            return $is_inserted;
        }

        /**
         * @param \PDO $pdo
         * @param string $user_login
         * @return array[
         *  'status' => bool,
         *  'exist' => bool,
         *  'data' => array ['id' => int, 'login' => string, 'password' => string]
         * ]
         */
        public function getUserData(string $user_login): array {
            $sth = $this->pdo->prepare('SELECT `id`, `login`, `password` FROM `users` WHERE `login`=:login LIMIT 1');
            $status = $sth->execute(['login' => htmlspecialchars($user_login)]);
            $result = $sth->fetch();
            $exist = (bool)$sth->rowCount();
            
            return ['status' => $status, 'exist' => $exist, 'data' => $result];
        }
    }