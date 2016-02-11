<?php
    namespace PSDO\Core;

    class AppLog {
        private $data = [];
        private $lock = false;

        public function __construct() {
            //
        }

        public function add($object) {
            if ($this->lock) {
                die("Cant write after render!");
                return false;
            }

            $this->data[] = $object;
            return true;
        }

        public function getAsText($lock = true) {
            $output = "";

            foreach ($this->data as $key => $value) {
                $output .= $key . " :: " . $value . "\n";
            }

            $this->lock = $lock;
            return $output;
        }
    }