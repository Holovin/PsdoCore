<?php
    namespace PSDO\Core;

    use PSDO\Core\UrlData;
    use PSDO\Config\DatabaseConfig;
    use PSDO\Storage\Database;
    use PSDO\View\Documents\HtmlDocument;

    class Application extends Singleton {
        /** @var HtmlDocument */
        private $document = null;

        /** @var Database */
        private $db = null;

        public function __construct() {
            // view
            $this->document = HtmlDocument::getInstance();

            $this->document->loadLayout([
                "cssLibs" => array(),
                "jsLibs" => array(),
                "metaLines" => array(),
                "title" => "PSDO v3!"
                                        ]);

            // db
            $dbConfig = DatabaseConfig::getInstance();
            $this->db = Database::getInstance();
            $this->db->connect($dbConfig->host, $dbConfig->dbName, $dbConfig->user, $dbConfig->password);

            // execute controller
            $url = UrlData::getInstance();
            $this->execute($url->controller, $url->action, $url->params);
        }

        protected function execute($controller = null, $action = null, $params = []) {
            echo $controller." - ".$action." - ".json_encode($params);
            // TODO: сделать контроллера запуск
            // и сами контроллеры!
        }
    }