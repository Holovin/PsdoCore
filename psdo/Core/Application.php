<?php
    namespace PSDO\Core;

    use PSDO\Core\UrlData;
    
    class Application {
        private $params;

        public function __construct() {
            $url = UrlData::getInstance();
        }
    }