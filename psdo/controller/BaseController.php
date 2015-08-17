<?php
    namespace PSDO\Controller;

    use PSDO\Storage\Database;

    class BaseController {
        /** @var Database */
        protected $db = null;

        public function __construct() {
            $this->db = Database::getInstance();
        }
    }