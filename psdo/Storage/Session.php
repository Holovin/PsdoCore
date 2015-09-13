<?php
    namespace PSDO\Storage;

    use PDO;
    use PSDO\Core\Application;
    use PSDO\Enums\Session\SessionSocial;
    use PSDO\Storage\Database;
    use PSDO\Core\Singleton;
    use PSDO\Enums\Session\SessionState;
    
    class Session {
        /** @var \PDO */
        protected $db = null;

        protected $data = [
            "sid" => null,
            "state" => SessionState::NotInit,

            "userId" => null,

            "socialType" => SessionSocial::NotInit,
            "socialId" => null,
            "socialToken" => null,

            "userAgent" => null,
            "ip" => null,

            "startTime" => null,
            "expires" => null,
        ];

        const tableName = "sessions";
        const storageName = "sid";
        const sidSize = 32;

        public function __construct() {
            $this->db = Database::getInstance()->getConnector();
        }

        // sid
        public function readSidFromUser() {
            if (!empty($_COOKIE[$this::storageName])) {
                $this->data["sid"] = substr($_COOKIE[$this::storageName], 0, $this::sidSize);
                Application::getInstance()->log->add("ok sid: ".$this->data["sid"]);
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

        public function __get($key) {
            if (array_key_exists($key, $this->data)) {
                return $this->data[$key];
            }

            return null;
        }

        // start
        public function startGuest($data = []) {
            $data["userId"] = -1;
            $data["state"] = SessionState::Guest;

            $data["socialType"] = SessionSocial::Native;
            $data["socialToken"] = "-1";
            $data["socialId"] = -1;

            return $this->start($data);
        }

        public function start($data) {
            $this->data = $data;

            do {
                $this->data["sid"] = $this->generateSid();
            } while ($this->loadData($this->data["sid"], true));

            $data["sid"] = $this->data["sid"];

            setcookie($this::storageName, $this->data["sid"], time() + (31 * 24 * 60 * 60), "/");
            return $this->saveData($data);
        }

        public function updateData($data) {
            $this->data = $data;
            return $this->saveData($data);
        }

        public function startOrResume($data = []) {
            // sid exist and valid
            if ($this->readSidFromUser() && $this->loadData($this->data["sid"])) {
                // TODO: validate time
                return true;
            }

            // new guest session
            return $this->startGuest($data);
        }

        public function stop() {
            if (isset($_COOKIE[$this::storageName])) {
                unset($_COOKIE[$this::storageName]);
                setcookie($this::storageName, null, -1, '/');

                if ($this->removeData($this->data["sid"])) {
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

        // load/save
        protected function saveData($data = []) {
            $query = $this->db->prepare("REPLACE INTO `".$this::tableName."` (`id`, `state`, `user_id`, `social_type`, `social_id`, `social_token`, `user_agent`, `ip`, `start_time`, `expires`) ".
                                        "VALUES (:sid, :state, :user_id, :social_type, :social_id, :social_token, :user_agent, :ip, :start_time, :expires)");

            $query->bindParam("sid", $data["sid"], PDO::PARAM_STR);
            $query->bindParam("state", $data["state"], PDO::PARAM_INT);

            $query->bindParam("user_id", $data["userId"], PDO::PARAM_INT);

            $query->bindParam("social_type", $data["socialType"], PDO::PARAM_INT);
            $query->bindParam("social_id", $data["socialId"], PDO::PARAM_INT);
            $query->bindParam("social_token", $data["socialToken"], PDO::PARAM_STR);

            $query->bindParam("user_agent", $data["userAgent"], PDO::PARAM_STR);
            $query->bindParam("ip", $data["ip"], PDO::PARAM_STR);

            $query->bindParam("start_time", $data["startTime"], PDO::PARAM_INT);
            $query->bindParam("expires", $data["expires"], PDO::PARAM_INT);

            if ($query->execute()) {
                Application::getInstance()->log->add("Save ok");
                return true;
            }

            return false;
        }

        public function loadData($sid, $onlyCheck = false) {
            Application::getInstance()->log->add("find sid: ".$sid);
            $query = $this->db->prepare("SELECT `state`, `user_id`, `social_type`, `social_id`, `social_token`, `user_agent`, `ip`, `start_time`, `expires` FROM `".$this::tableName."` WHERE `id` = :sid");
            $query->bindParam("sid", $sid);
            $query->execute();

            if ($query->rowCount() == 1) {
                if ($onlyCheck) {
                    return true;
                }

                $result = $query->fetch(PDO::FETCH_OBJ);

                $this->data["sid"] = $sid;
                $this->data["state"] = $result->state;
                $this->data["userId"] = $result->user_id;

                $this->data["socialType"] = $result->social_type;
                $this->data["socialToken"] = $result->social_token;
                $this->data["socialId"] = $result->social_id;

                $this->data["ip"] = $result->ip;
                $this->data["userAgent"] = $result->user_agent;

                $this->data["startTime"] = $result->start_time;
                $this->data["expires"] = $result->expires;

                return true;
            } else {
                return false;
            }
        }

        // state control
        public function getState() {
            return $this->data["state"];
        }

        public function setState($state) {
            Application::getInstance()->log->add("Set state: ".$state);
            $this->data["state"] = $state;
            $this->saveData($this->data);
        }

        // data
        public function getData($key) {
            if (array_key_exists($key, $this->data)) {
                return $this->data[$key];
            }

            return false;
        }
    }