<?php
    namespace PSDO\Core;


    abstract class Singleton {

        /**
         * @return Singleton
         */
        public static function getInstance() {
            static $instance = null;

            if (null === $instance) {
                $instance = new static();
            }

            return $instance;
        }

        final protected function __clone() {
        }

        protected function __construct() {
        }
    }