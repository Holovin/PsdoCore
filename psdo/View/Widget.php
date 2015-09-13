<?php
    namespace PSDO\View;

    class Widget {
        const path = 'View/Widgets/';

        protected $selfName = 'Blank';
        protected $data = [];

        public function __construct($widgetName = 'Blank', $data = array()) {
            $this->selfName = $widgetName;
            $this->data = $data;
        }

        public function __toString() {
            $a = $this->load();
            return $a;
        }

        protected function load() {
            if (!empty($this->selfName) && file_exists(PSDO_ROOT_DIR.$this::path.$this->selfName.'.php')) {
                extract($this->data);
                ob_start();
                require PSDO_ROOT_DIR.static::path.$this->selfName.'.php';
                return ob_get_clean();
            } else {
                // TODO: fix!
                var_dump($this->selfName);
            }
            return "";
        }
    }