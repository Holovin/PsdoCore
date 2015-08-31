<?php
    namespace PSDO\Core;

    class AppLog {
        private $data = [];

        public function __construct() {
            //
        }

        public function add($object) {
            $this->data[] = $object;
        }

        public function getAsText() {
            $output = "";

            foreach ($this->data as $key => $value) {
                $output .= $key . " :: " . $value . "\n";
            }

            return $output;
        }
    }