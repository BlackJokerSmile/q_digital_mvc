ALTER TABLE `tasks` ADD CONSTRAINT `fk_tasks_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `tasks` ALTER COLUMN `status` SET DEFAULT 'unready';