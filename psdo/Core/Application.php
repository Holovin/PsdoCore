<?php
    namespace PSDO\Core;

    use PSDO\Controller;
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

        /** @var array Routes map */
        const routes = [
            "auth" => "PSDO\\Controller\\Web\\AuthController"
        ];

        /** @var array Routes map with regex support */
        protected $routesEx = [
            "/^id(\\d+)$/" => ["PSDO\\Controller\\Web\\AuthController", "zhumarin"]
        ];

        /** @var \PSDO\View\Documents\HtmlDocument */
        protected $document = null;

        protected function construct() {
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

            if (array_key_exists($controllerName, $this::routes)) {
                $temp = $this::routes[$controllerName];
                $controller = new $temp;
            } else if ($controllerName) {
                foreach($this->routesEx as $key => $value) {
                    if (preg_match($key, $controllerName, $matches)) {
                        $controller = new $value[0]();
                        $actionName = $value[1];

                        for ($i = 1; $i < count($matches); $i++) {
                            $params['_'.$i] = $matches[$i];
                        }
                    }
                }
            } else {
                $controller = new Controller\WebController();
            }

            if (!$controller) {
                $controller = new Controller\WebController();
                $actionName = "notFound";
            }

            $controller->run($actionName, $params);
        }
    }