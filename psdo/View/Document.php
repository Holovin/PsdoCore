<?php
    namespace PSDO\View;

    use PSDO\Core\Singleton;
    
    abstract class Document extends Singleton {
        protected $bodyContent = null;

        public function writeRaw($data) {
        }

        public function render() {
        }

        public function getBodyContent() {
        }
    }