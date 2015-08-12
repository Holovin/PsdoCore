<?php
    namespace PSDO\Config;

    use PSDO\Core\Singleton;

    abstract class AbstractConfig extends Singleton {
        const configStoreName = 'Abstract';

        protected $data = null;

        protected function load() {
            return;
        }

        protected function tryLoadCache() {
            $temp_config = apcu_fetch("PSDO_CONFIGS_".$this::configStoreName);

            if ($temp_config) {
                $this->data = $temp_config;
                return true;
            }

            return false;
        }

        public function removeCache() {
            apcu_delete("PSDO_CONFIGS_".$this::configStoreName);
        }

        protected function __construct() {
            if (!$this->tryLoadCache()) {
                $this->load();
                apcu_store("PSDO_CONFIGS_".$this::configStoreName, $this->data);
            }
        }

        public function __call($name, $nvm) {
            if (!isset($this->data[$name])) {
                $this->load();
            }

            return $this->data[$name];
        }

        public function __get($key) {
            if (array_key_exists($key, $this->data)) {
                return $this->data[$key];
            }
        }
    }