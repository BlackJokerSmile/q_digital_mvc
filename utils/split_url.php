<?php
    namespace Util;

    function split_url() {
        $url = \Util\get_url();
        $segments = explode('/', $url);

        return [$segments[1], $segments[2], $segments[3]];
    }
