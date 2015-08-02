<?php
    namespace PSDO\Core;

    use PSDO\Core\Singleton;
    
    class UrlData extends Singleton {
        private $controller;
        private $action;
        private $params;

        public function __construct() {
            $this->parse();
        }

        private function parse() {
            var_dump($_SERVER['REQUEST_URI']);

            $data = preg_split("/[?]/", $_SERVER['REQUEST_URI'], null, PREG_SPLIT_NO_EMPTY);

            if (count($data) > 0) {
                $temp = preg_split("/[\/]/", $data[0], null, PREG_SPLIT_NO_EMPTY);

                $this->controller = isset($temp[0]) ? $temp[0] : null;
                $this->action = isset($temp[1]) ? $temp[1] : null;
            }

            if (count($data) > 1) {
                $params = preg_split("/[&]/", $data[1], null, PREG_SPLIT_NO_EMPTY);

                for ($i = count($params) - 1; $i >= 0; $i--) {
                    $temp = preg_split("/[=]/", $params[$i], null, PREG_SPLIT_NO_EMPTY);

                    if ($temp) {
                        if (count($temp) > 1) {
                            $this->params[$temp[0]] = $temp[1];
                        } else {
                            $this->params[$temp[0]] = null;
                        }
                    }
                }
            } else {
                $this->params = null;
            }
        }
    }