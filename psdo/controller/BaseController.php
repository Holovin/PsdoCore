<?php
    namespace PSDO\Controller;

    use PSDO\Storage\Database;

    abstract class BaseController {
        protected $db = null;

        function __construct() {
            $this->db = Database::getInstance();
        }

    }