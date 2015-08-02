<?php
    namespace PSDO\Core;

    require "AutoLoader.php";

    // settings
    date_default_timezone_set('Europe/Minsk');

    // auto loader
    $loader = new AutoLoader();
    $loader->register();
    $loader->addNamespace('PSDO', $_SERVER['DOCUMENT_ROOT'].'PSDO');

    // const
    define('PSDO_ENVIRONMENT', 'dev');
    define('PSDO_ROOT_DIR', $_SERVER['DOCUMENT_ROOT'].'PSDO/');

    // dev
    if (PSDO_ENVIRONMENT == 'dev') {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }