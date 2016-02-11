<?php
    namespace PSDO\Storage\Model;

    use PSDO\Storage\Database;
    
    abstract class Base {
        /** @var \PDO */
        protected $db = null;

        public function __construct() {
            $this->db = Database::getInstance()->getConnector();
        }

        public function create($data) {
            return false;
        }

        public function read($id, $data) {
            return null;
        }

        public function update($id, $data) {
            return false;
        }

        public function delete($id) {
            return false;
        }
    }