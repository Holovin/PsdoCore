<?php
    if (!defined('PDO::ATTR_DRIVER_NAME')) {
        echo 'PDO unavailable';
    }

    require_once "PSDO/Core/Init.php";

    use PSDO\Core\Application;

    Application::getInstance();