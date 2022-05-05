<?php
    class AuthController extends Controller {
        public function main(){
            $user_model = new UserModel();

            $login = $_POST['login'];
            $password = $_POST['password'];

            $not_empty = !empty($login) && !empty($password);

            if ($not_empty) {
                // if all fields filled by user
                $db_userdata = $user_model->getUserData($login);

                if (!$db_userdata['status']) {
                    // if cannot connect to query
                    $message = 'Server error occured, please try later!';
                } elseif ($db_userdata['exist']) {
                    // if user exist in database
                    if (password_verify($password, $db_userdata['data']['password'])) {
                        // restart session if password is correct 
                        // and set session vars, redirect to main page
                        \Util\restart_session([
                            'session_user' => $db_userdata['data']['login'],
                            'session_user_id' => $db_userdata['data']['id']
                        ]);
                        
                        \Util\redirect('/');
                    } else {
                        // if password is incorrect
                        $error_message = 'Invalid password';
                    }
                } else {
                    // create user if not exist
                    $is_created = $user_model->createUser($login, $password);

                    if ($is_created) {
                        // get data about new user
                        $db_userdata = $user_model->getUserData($login);

                        \Util\restart_session([
                            'session_user' => $db_userdata['data']['login'],
                            'session_user_id' => $db_userdata['data']['id']
                        ]);

                        \Util\redirect('/');
                    } else {
                        $message = 'Server error occured, please try later!';
                    }
                }

            } else {
                // if some field is empty
                $error_message = 'All fields required';
            }

            require VIEWS_PATH . 'AuthView.php';
        }
    }
