<?php
    namespace Util;

    function get_url() {
        return strtok($_SERVER["REQUEST_URI"], '?');
    }
