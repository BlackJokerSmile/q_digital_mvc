<?php
    namespace Util;

    /**
    * @param string $url
    * @param integer $statusCode
    * @return void
    */
    function redirect(string $url, int $statusCode = 303): void {
        header('Location: ' . $url, true, $statusCode);
        exit();
    }
