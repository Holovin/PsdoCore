<?php
    namespace PSDO\Model;

    use PSDO\Storage\Database;

    abstract class BaseModel {
        /** @var \PDO */
        protected $db = null;

        public function __construct() {
            $db = Database::getInstance()->getConnector();
        }
    }