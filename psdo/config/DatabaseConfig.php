<?php
    namespace PSDO\Config;


    class DatabaseConfig extends AbstractConfig {

        public function Load() {
            $this->data['host']             = 'localhost';
            $this->data['login']            = 'psdo3ez';
            $this->data['password']         = 'psdo3ez';
            $this->data['db']               = 'psdo';
        }

        public function  __construct() {
            parent::__construct();
            $this->Load();
        }
    }