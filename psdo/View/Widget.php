<?php
    namespace PSDO\View;

    abstract class Widget {
        protected $path = 'Widgets/';
        protected $content = '';

        public function __construct($widget, $args = array(), $autoWrite = true) {
            if (!empty($widget) && file_exists($this->path.$widget.".php")) {
                $this->Load($this->path.$widget.".php", $args);

                if ($autoWrite) {
                    Document::getInstance()->write($this->content);
                }
            }
        }

        protected function Load($path, $args = array()) {
            extract($args);
            ob_start();
            require $path.".php";
            $this->content = ob_get_clean();
        }
    }