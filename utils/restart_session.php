<?php
    namespace Util;
    
    /**
     * @param array|null $session_vars
     * @return void
     */
    function restart_session(?array $session_vars = null): void {
        session_destroy();
        session_start();
        if (!empty($session_vars)) {
            foreach ($session_vars as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
        return;
    }