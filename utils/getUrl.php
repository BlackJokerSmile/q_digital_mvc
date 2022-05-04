<?php
    function getUrl() {
        return strtok($_SERVER["REQUEST_URI"], '?');
    };
