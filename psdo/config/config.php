<?php
    namespace PSDO\Config;

    define('PSDO_ENVIRONMENT', 'dev');

    // dev
    if (PSDO_ENVIRONMENT == 'dev') {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }