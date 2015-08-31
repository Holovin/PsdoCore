<?php
    namespace PSDO\Controller;

    use PSDO\Core\Application;
    use PSDO\Core\UrlData;
    use PSDO\Core\UrlGoto;
    use PSDO\Storage\Session;
    use PSDO\View\Documents\HtmlDocument;
    use PSDO\Model\UserModel;
    use PSDO\View\Widget;

    class WebController extends BaseController {
        /** @var Session */
        protected $session = null;

        /** @var UserModel */
        protected $user = null;

        /** @var HtmlDocument */
        protected $document;

        /** @var array Routes (with regEx process) map */
        protected $routesEx = [];

        /** @var array Routes map, ex. "action-super-2015" => "indexAction" */
        protected $routes = [];

        public function __construct($data = []) {
            parent::__construct($data);
            $this->session = new Session();
            $this->session->startOrResume([
                "userAgent" => $_SERVER['HTTP_USER_AGENT'],
                "ip" => $_SERVER["REMOTE_ADDR"],
                "startTime" => time(),
                "expires" => "600"
            ]);
        }

        protected function redirect($urlTo, $code = 301) {
            header("Location: ".$urlTo, true, $code);
        }

        protected function indexAction($params = []) {
            Application::getInstance()->log->add(UrlGoto::get("auth", "123", ["test" => "1", "test2" => "2"]));

            $this->document->writeRaw('Its main page!<br /><a href="/auth/vkLogin">Login vk</a>');
        }

        protected function notFoundAction($params = []) {
            $this->document->writeRaw("404!");
        }

        public function run($action, $params = []) {
            $this->document = HtmlDocument::getInstance();

            if (isset($this->routes['$action'])) {
                // check map 1st
                $this->{$this->routes[$action]}($params);
            } else if (method_exists($this, $action."Action")) {
                // run directly
                $this->{$action."Action"}($params);
            } else if ($action) {
                // run default 404
                $this->notFoundAction($params);
            } else {
                $this->indexAction($params);
            }

            // DEBUG //
            $a = new Widget("Debug/DebugBot", [
                "controller" => UrlData::getInstance()->controller,
                "controllerReal" => get_called_class(),
                "action" => $action,
                "params" => json_encode($params),
                "sid" => $this->session->sid,
                "id" => "n/a [не сделано же]",
                "log" => Application::getInstance()->log->getAsText(),
            ]);
            $this->document->writeRaw($a);
            // END DEBUG //

            $this->document->render();
        }
    }