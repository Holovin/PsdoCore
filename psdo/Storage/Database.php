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

        /** @var Config\DatabaseConfig */
        public $config = null;

        public function __construct() {
            $this->connect();
        }

        protected function connect() {
            try {
                $this->config = Config\DatabaseConfig::getInstance();
                $conf_data = $this->config->getAll();
                $this->connector = new PDO('mysql:host='.$conf_data['host'].';'.'dbname='.$conf_data['db'], strval($conf_data['login']), strval($conf_data['password']));
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