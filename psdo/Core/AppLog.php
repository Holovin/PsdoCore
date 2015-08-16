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
            return json_encode($this->data);
        }
    }