<?php
    namespace PSDO\Core;


    abstract class Singleton {
        public static function getInstance() {
            static $instance = null;

            if ($instance === null) {
                $instance = new static();
                $instance->construct();
            }

            return $instance;
        }

        final protected function __clone() {
            //
        }

        final protected function __construct() {
            //
        }

        protected function construct() {
            //
        }
    }