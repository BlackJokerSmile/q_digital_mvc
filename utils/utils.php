<?php
    namespace Util;

    // include all util files
    foreach (glob(UTILS_PATH . '*.php') as $filename) {
        if ($filename !== __FILE__) {
            require_once($filename);
        }
    }
