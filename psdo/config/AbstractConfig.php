<?php
    namespace PSDO\Config;

    use PSDO\Core\Singleton;

    abstract class AbstractConfig extends Singleton {
        public $data = null;

        protected function Load() {
            return;
        }

        protected function __construct() {
            $this->Load();
        }

        public function getVar($name) {
            return array_key_exists($name, $this->data) ? $this->data[$name] : null;
        }

        public function getAll() {
            return $this->data;
        }
    }