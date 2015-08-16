<?php
    namespace PSDO\Core;

    use PSDO\Controller\BaseController;
    use PSDO\Controller\MainController;
    use PSDO\Controller\WebController;
    use PSDO\Core\UrlData;
    use PSDO\Config\DatabaseConfig;
    use PSDO\Storage\Database;
    use PSDO\View\Documents\HtmlDocument;
    use PSDO\Core\AppLog;

    class Application extends Singleton {
        /** @var Database */
        private $db = null;

        /** @var AppLog */
        public $log = null;

        protected function construct() {
            // core
            $this->log = new AppLog();

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

        protected function execute($controllerName = null, $actionName = null, $params = []) {
            $controller = null;

            switch ($controllerName) {
                case "test": {
                    $controller = new BaseController();
                    break;
                }

                default: {
                    $controller = new WebController();
                    break;
                }
            }

            $controller->runAction($actionName, $params);
        }
    }