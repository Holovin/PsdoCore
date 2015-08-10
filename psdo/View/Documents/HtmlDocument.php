<?php
    namespace PSDO\View\Documents;

    use PSDO\View\Document;
    use PSDO\View\Widget;
    use PSDO\Config;

    class HtmlDocument extends Document {
        const path = 'Layouts/';

        protected $layoutName = null;

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

        public function __construct() {
            //
        }

        public function loadLayout() {
            $layoutConfig = null;
            require $this::path.'Web.php';
            extract($layoutConfig);
            echo $test;
        }

        protected function setLayout($name) {
            $this->layoutName = $name;
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