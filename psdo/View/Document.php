<?php
    namespace PSDO\View;

    use PSDO\Core\Singleton;
    
    class Document extends Singleton {
        private $content;

        private $jsLibs = [];
        private $cssLibs = [];

        public function addJs() {
            // TODO
        }

        public function addCss() {
            // TODO
        }

        public function __construct() {
            // TODO
        }

        public function write($data) {
            $this->content.= $data;

            return $this;
        }

        public function render() {
            echo $this->content;
        }
    }