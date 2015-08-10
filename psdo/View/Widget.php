<?php
    namespace PSDO\View;

    class Widget {
        const path = 'View/Widgets/';

        protected $widgetName = 'Blank';
        protected $content = null;
        protected $data = [];

        public function __construct($widgetName = 'Blank', $data = array()) {
            $this->widgetName = $widgetName;
            $this->data = $data;
        }

        public function __toString() {
            $a = $this->load();
            return $a;
        }

        protected function load() {
            if (!empty($this->widgetName) && file_exists(PSDO_ROOT_DIR.$this::path.$this->widgetName.'.php')) {
                extract($this->data);
                ob_start();
                require PSDO_ROOT_DIR.static::path.$this->widgetName.'.php';
                return ob_get_clean();
            } else {
                var_dump($this->widgetName);
            }
        }
    }