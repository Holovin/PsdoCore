<?php
    namespace PSDO\Core;

    class UrlGoto {
        const Http = "http://";

        public static function getHostName() {
            if (!empty($_SERVER["HTTP_HOST"])) {
                return $_SERVER["HTTP_HOST"];
            } else {
                return $_SERVER["SERVER_NAME"];
            }
        }

        public static function getHostHttpName() {
            return self::Http.self::getHostName();
        }

        public static function paramsArrayToString($params = []) {
            if (empty($params)) {
                return "";
            }

            $output = "?";

            // TODO: urlencode?
            foreach ($params as $key => $value ) {
                $output .= $key . "=" .$value . "&";
            }

            return rtrim($output, "&");
        }

        public static function get($controller, $action, $params = []) {

            if (array_key_exists($controller, Application::routes)) {
                // TODO: check action? how?

                return self::getHostHttpName().'/'.$controller.'/'.$action.'/'.self::paramsArrayToString($params);
            }

            Application::getInstance()->log->add("[WARN] UrlGoto incorrect controller (" . $controller . ")");
            return self::getHostHttpName();
        }
    }