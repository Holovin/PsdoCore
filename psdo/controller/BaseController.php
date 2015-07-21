<?php
    namespace PSDO\Controller;

    class BaseController {
        // data
        public $db = null;
        public $model = null;
        public $test = "";

        // constr
        function __construct() {
            // just debug
            $this->test = "Hello from controller!";
        }

    }