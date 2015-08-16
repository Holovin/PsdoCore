<?php
    namespace PSDO\Model;

    use \PDO;

    class UserModel extends BaseModel {
        const tableName = "Users";

        private $id = null;
        private $authType = null;
        private $userId = null;

        public function __construct() {
            parent::__construct();
        }

        public function loadUserById($id) {
            if (empty($id)) {
                return false;
            }

            $this->id = $id;

            // db
            $query = $this->db->prepare("SELECT `vk_id` FROM `".$this::tableName."` WHERE `id` = :id");
            $query->bindParam("id", $id, PDO::PARAM_INT);
            if (!$query->execute()) {
                return false;
            }

            // parse
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->userId = $result->vk_id;

            return true;
        }


    }