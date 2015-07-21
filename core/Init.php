<?php
    namespace Core;

    require "AutoLoader.php";

        // settings
        date_default_timezone_set('Europe/Minsk');

        // auto loader
        $loader = new AutoLoader();
        $loader->register();
        $loader->addNamespace('PSDO', 'PSDO');
