<?php
    namespace PSDO\Core;

    require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

    // settings
    date_default_timezone_set('Europe/Minsk');

    // const
    define('PSDO_ENVIRONMENT', 'dev');
    define('PSDO_ROOT_DIR', $_SERVER['DOCUMENT_ROOT'].'PSDO/');

    // dev
    if (PSDO_ENVIRONMENT == 'dev') {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }