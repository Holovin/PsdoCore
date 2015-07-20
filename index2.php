<?php
    spl_autoload_register(function ($class) {
        require_once $_SERVER['DOCUMENT_ROOT'].'psdo/libs/'.str_replace("\\", "/", $class).".php";
    });

    $logger = new Katzgrau\KLogger\Logger('log');
    $logger->log(Psr\Log\LogLevel::INFO, "test");

