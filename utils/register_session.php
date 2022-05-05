<?php
    namespace Util;

    /**
     * @return string|void
     */
    function register_session(): string {
        session_start();

        $session_user = $_SESSION["session_user"];

        if(!isset($session_user)) {
            session_destroy();
            if ($_SERVER['REQUEST_URI'] != '/auth') {
                \Util\redirect('/auth');
            }
        }
        
        return $session_user;
    }
 