<?php
    namespace PSDO\Model;

    use \PDO;

    use PSDO\Enums\Enum;
    use PSDO\Core\Application;

    class UserModel extends BaseModel {
        const tableName = "users";

        /** @var int PsdoID */
        private $id = null;

        private $socialType = null;

        /** @var int Socal network user id */
        private $socialId = null;

        /** @var string Params part for autologin without social  */
        private $authFastKey = null;

        public function __construct() {
            parent::__construct();
        }

        public function load($socialType, $socialId) {
            $this->socialType = $socialType;
            $this->socialId = $socialId;

            $query = $this->db->prepare("SELECT `id` FROM `".$this::tableName."` WHERE `socal_type` = :socT AND `social_id` = :socId");
            $query->bindParam("socT", $socialType, PDO::PARAM_INT);
            $query->bindParam("socId", $socialId, PDO::PARAM_INT);

            if (!$query->execute()) {
                Application::getInstance()->log->add("[WARN] А вот и ошибки подъехали! UserModel db fault");
                return false;
            }

            if ($query->rowCount()) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $this->id = $result->id;
                return true;
            }

            return false;
        }
    }