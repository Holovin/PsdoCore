<?php
    namespace PSDO\Storage;

    use PDO;
    use Exception;
    use PSDO\Core\Singleton;
    use PSDO\Config;

    class Database extends Singleton {
        // TODO: [DB] Add init options
        // Add init options like this:
        // array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)

        /** @var \PDO */
        public $connector = null;

        private $host = null;
        private $dbName = null;
        private $user = null;
        private $password = null;

        public function connect($host, $dbName, $user, $password) {
            $this->host = $host;
            $this->dbName = $dbName;
            $this->user = $user;
            $this->password = $password;

            try {
                $this->connector = new PDO('mysql:host='.$host.';'.'dbname='.$dbName, strval($user), strval($password));
            } catch (Exception $e) {
                // TODO: [DB] log errors
                echo "ERR: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        public function getConnector() {
            return $this->connector;
        }
    }