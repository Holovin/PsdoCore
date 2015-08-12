<?php
    namespace PSDO\Tests\Storage;

    use PSDO\Tests\BaseTest;
    use PSDO\Config\DatabaseConfig;
    use PSDO\Storage\Database as DB;

    class Database extends BaseTest  {
        const DB_CHECK_KEY = "29071995";

        protected function RunTest() {
            $db = DB::getInstance();
            $dbConfig = DatabaseConfig::getInstance();
            $db->connect($dbConfig->host, $dbConfig->dbName, $dbConfig->user, $dbConfig->password);

            $connection = $db->getConnector();
            $result = $connection->query('SELECT testvalue FROM test WHERE `id` = 1');

            if ($result->rowCount() !== 1) {
                $this->WriteData("Error", "Incorrect row count");
                return;
            }

            if ($result->fetch()[0] !== $this::DB_CHECK_KEY) {
                $this->WriteData("Error", "Incorrect check key");
                return;
            }

            $this->SetSuccess("Test done");
        }
    }