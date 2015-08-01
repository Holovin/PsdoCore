<?php
    namespace PSDO\Controller;

    use PSDO\Storage\Database;

    class BaseController {
        // data
        public $db = null;
        public $model = null;

        // constr
        function __construct() {
            $this->db = Database::getInstance();
        }

    }