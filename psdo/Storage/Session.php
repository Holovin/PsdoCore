<?php
    namespace PSDO\Storage;

    use PDO;
    use PSDO\Storage\Database;
    use PSDO\Core\Singleton;
    
    class Session extends Singleton {
        /** @var \PDO */
        protected $db = null;

        public $sid = null;
        public $userId = null;

        const tableName = "sessions";
        const storageName = "sid";
        const sidSize = 32;

        protected function construct() {
            $this->db = Database::getInstance()->getConnector();
        }

        public function startOrResume($startData = array(), $override = false) {
            if ($this->readSid() && $this->readData($this->sid) && !$override) {
                return;
            }

            $this->start($startData);
            return;
        }

        public function stop() {
            if (isset($_COOKIE[$this::storageName])) {
                unset($_COOKIE[$this::storageName]);
                setcookie($this::storageName, null, -1, '/');

                if ($this->removeData($this->sid)) {
                    return true;
                }
            }

            return false;
        }

        protected function removeData($sid) {
            $query = $this->db->prepare("DELETE FROM `".$this::tableName."` WHERE `id` = :sid");
            $query->bindParam("sid",  $sid, PDO::PARAM_STR);

            if ($query->execute()) {
                return true;
            }

            return false;
        }

        protected function generateSid() {
            $sid = "";

            for ($i = 0; $i < $this::sidSize; $i++) {
                $sid .= mt_rand(0, 9);
            }

            return $sid;
        }

        public function start($data = array()) {
            if (empty($data)) {
                // TODO: error!
            }

            $this->userId = $data["userId"];

            do {
                $this->sid = $this->generateSid();
            } while ($this->readData($this->sid, true));

            setcookie($this::storageName, $this->sid, time() + (31 * 24 * 60 * 60), "/");
            $this->writeData($this->sid, $this->userId);
        }

        protected function writeData($sid, $userId) {
            $query = $this->db->prepare("INSERT INTO  `".$this::tableName."` (`id`, `user_id`) VALUES (:sid, :user_id)");
            $query->bindParam("sid", $sid, PDO::PARAM_STR);
            $query->bindParam("user_id", $userId, PDO::PARAM_INT);

            if ($query->execute()) {
                return true;
            }

            return false;
        }

        public function readSid() {
            if (!empty($_COOKIE[$this::storageName])) {
                $this->sid = substr($_COOKIE[$this::storageName], 0, $this::sidSize);
                return true;
            }

            return false;
        }

        public function readData($sid, $onlyCheck = false) {
            $query = $this->db->prepare("SELECT `user_id` FROM `".$this::tableName."` WHERE `id` = :sid");
            $query->bindParam("sid", $sid, PDO::PARAM_STR);
            $query->execute();

            if ($query->rowCount() == 1) {
                if ($onlyCheck) {
                    return true;
                }

                $result = $query->fetch(PDO::FETCH_OBJ);
                $this->userId = $result->user_id;
                return true;
            } else {
                // TODO: Error check?
                return false;
            }
        }
    }