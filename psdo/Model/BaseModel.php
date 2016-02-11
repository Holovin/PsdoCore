<?php
    namespace PSDO\Model;

    use PSDO\Core\Application;

    abstract class BaseModel {
        public function __construct() {

        }

        public function __set($key, $value) {
            $this->{$key} = $value;
        }

        public function fillData($data) {
            if (array_values($data) === $data) {
                echo "err";
                Application::getInstance()->log->add("[FATAL] Wrong array type");
                return false;
            }

            foreach($data as $key => $value) {
                if (!property_exists($this, $key)) {
                    Application::getInstance()->log->add("[FATAL] Trying writing to this->".$key);
                    return false;
                }

                $this->{$key} = $value;
            }

            return true;
        }
    }