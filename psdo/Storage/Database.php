<?php
    namespace PSDO\Storage;

    use PDO;
    use Exception;
    use PSDO\Core\Singleton;
    use PSDO\Config;

    class Database extends Singleton {
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
                echo "----------";
            } catch (Exception $e) {
                // TODO: log this
                echo "ERR: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        public function getConnector() {
            return $this->connector;
        }
    }