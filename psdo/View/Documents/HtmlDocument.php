<?php
    namespace PSDO\View\Documents;

    use PSDO\View\Document;
    use PSDO\View\Widget;
    use PSDO\Config;

    class HtmlDocument extends Document {
        protected $jsLibs = [];
        protected $cssLibs = [];
        protected $metaLines = [];
        protected $title = null;

        public function writeRaw($data) {
            $this->bodyContent .= $data;
        }

        public function render() {
            $headConfig['title'] = $this->title;
            $headConfig['js'] = $this->jsLibs;
            $headConfig['css'] = $this->cssLibs;
            $headConfig['meta'] = $this->metaLines;
            $headConfig['after'] = '';
            echo new Widget('Html/Head', $headConfig);

            $bodyConfig['content'] = $this->bodyContent;
            $bodyConfig['class'] = '';
            echo new Widget('Html/Body', $bodyConfig);

            $footConfig['before'] = '';
            $footConfig['after'] = '';
            echo new Widget('Html/Foot', $footConfig);
        }

        public function loadLayout($globalParams = array()) {
            $this->jsLibs = $globalParams['jsLibs'];
            $this->cssLibs = $globalParams['cssLibs'];
            $this->metaLines = $globalParams['metaLines'];
            $this->title = $globalParams['title'];
        }

        public function addTitle($title) {
            $this->title .= $title;
        }

        public function setTitle($title) {
            $this->title = $title;
        }

        public function addJs($value) {
            $this->addLib("jsLibs", $value);
        }

        public function addCss($value) {
            $this->addLib("cssLibs", $value);
        }

        protected function addLib($storeName, $value) {
            if (!in_array($value, $this->$storeName)) {
                //$this->$storeName[] = $value;
                return;
            }
            // TODO
        }
    }