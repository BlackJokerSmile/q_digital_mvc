<?php
    class IndexController extends Controller {
        public function main() {
            $task_model = new \TaskModel();

            $db_tasks = $task_model->get_all_tasks(SESSION_USER);

            require VIEWS_PATH . 'IndexView.php';
        }

        public function add() {
            $description = $_POST['description'];
            
            if (empty(SESSION_USER_ID)) {
                $message = 'You are not logged in';
            } elseif (empty($description)) {
                $message = 'Description cannot be empty';
            } else {
                $task_model = new \TaskModel();

                $is_created =  $task_model->add_task($description, SESSION_USER_ID);

                $message = $is_created ? 'Sucessfully created task' : 'Server error occured, please try later';
            }

            \Util\redirect($_SERVER['HTTP_REFERER']);
        }

        public function edit() {
            $action = $_POST['action'];
            $task_id = $_POST['task_id'];

            if (empty(SESSION_USER_ID)){
                $message = 'You are not logged in';
            } elseif (empty($action) || empty($task_id)) {
                $message = 'Some inputs are empty';
            } else {
                $task_model = new \TaskModel();

                $is_created = $task_model->edit_task($action, $task_id, SESSION_USER_ID);

                $message = $is_created ? 'Sucessfully edited task' : 'Server error occured, please try later';
            }

            \Util\redirect($_SERVER['HTTP_REFERER']);
        }

        public function edit_all() {
            $action = $_POST['action'];

            if (empty(SESSION_USER_ID)){
                $message = 'You are not logged in';
            } elseif (empty($action)) {
                $message = 'Action field should not be empty';
            } else {
                $task_model = new \TaskModel();

                $is_created = $task_model->edit_all_tasks($action, SESSION_USER_ID);

                $message = $is_created ? 'Sucessfully edited task' : 'Server error occured, please try later';
            }

            \Util\redirect($_SERVER['HTTP_REFERER']);
        }
    }
