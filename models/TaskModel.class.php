<?php
    class TaskModel extends Model {
        public function add_task(string $description, int $user_id): bool {
            $sth = $this->pdo->prepare(
                'INSERT INTO `tasks`(`description`, `user_id`) VALUES (:description, :userid)'
            );

            $is_created = $sth->execute([
                'description' => htmlspecialchars($description),
                'userid' => $user_id
            ]);
            
            return $is_created;
        }

        public function edit_task(string $action, int $task_id, int $user_id): bool {
            switch ($action) {
                case 'ready':
                    $query = "UPDATE `tasks` SET `status`='ready' WHERE `id`=:task_id AND `user_id`=:userid";
                    break;
    
                case 'unready':
                    $query = "UPDATE `tasks` SET `status`='unready' WHERE `id`=:task_id AND `user_id`=:userid";
                    break;
    
                case 'delete':
                    $query = "DELETE FROM `tasks` WHERE `id`=:task_id AND `user_id`=:userid";
                    break;
    
                default:
                    return false;
            }

            $sth = $this->pdo->prepare($query);
            $is_success = $sth->execute([
                'task_id' => $task_id,
                'userid' => $user_id
            ]);

            return $is_success;
        }

        public function edit_all_tasks(string $action, int $user_id): bool {
            switch ($action) {
                case 'ready':
                    $query = "UPDATE `tasks` SET `status`='ready' WHERE `user_id`=:userid";
                    break;
    
                case 'remove':
                    $query = "DELETE FROM `tasks` WHERE `user_id`=:userid";
                    break;
    
                default:
                    return false;
            }

            $sth = $this->pdo->prepare($query);
            $is_success = $sth->execute([
                'userid' => $user_id
            ]);

            return $is_success;
        }

        public function get_all_tasks(string $user_login): array {
            $sth = $this->pdo->prepare(
                'SELECT `t`.`id`, `t`.`description`, `t`.`status` FROM `tasks` AS `t`, `users` as `u` WHERE `t`.user_id=`u`.id AND `u`.login=:login'
            );
            $sth->execute(['login' => htmlspecialchars($user_login)]);
            
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        }
    }