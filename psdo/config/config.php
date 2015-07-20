<?php
    define('PSDO_ENVIRONMENT', 'dev');

    // dev
    if (PSDO_ENVIRONMENT == 'dev') {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }

    // common
    define('URL_PROTOCOL', 'http://');
    define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

    // database
    define('PSDO_CFG_DB_HOST', 'localhost');
    define('PSDO_CFG_DB_NAME', 'psdo');
    define('PSDO_CFG_DB_USER', 'psdo3ez');
    define('PSDO_CFG_DB_PASS', 'psdo3ez');