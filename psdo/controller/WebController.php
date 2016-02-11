<?php
    namespace PSDO\Controller;

    use PSDO\Core\Application;
    use PSDO\Core\UrlData;
    use PSDO\Core\UrlGen;
    use PSDO\Enum\Session\SessionState;
    use PSDO\Storage\Session;
    use PSDO\View\Document\HtmlDocument;
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

            $this->document = new HtmlDocument();

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
            //$this->document;
        }

        protected function notFound($params = []) {
            $a = new Widget("Debug/DebugBot", $params);

            $this->document->writeRaw("404!");
        }

        public function run($action, $params = []) {
            if (isset($this->routes['$action'])) {
                // check map 1st
                $this->{$this->routes[$action]}($params);
            } else if (method_exists($this, $action."Action")) {
                // run directly
                $this->{$action."Action"}($params);
            } else if ($action) {
                // run default 404
                $this->notFound($params);
            } else {
                $this->indexAction($params);
            }

            if ($this->session->getData("state") != SessionState::Auth) {
                $link = UrlGen::get("auth", "vkLogin");
                $this->document->writeRaw('Не залогирован<br /><a href="' . $link . '">Login vk</a>');
            } else {
                $link = UrlGen::get("auth", "logout");
                $this->document->writeRaw('Залогирован<br /><a href="' . $link . '">Log out</a>');
            }

            // DEBUG //
            $this->document->write("Debug", 'debug_data', "Debug/DebugBot", [
                "sub" => UrlData::getInstance()->sub,
                "controller" => UrlData::getInstance()->controller,
                "controllerReal" => get_called_class(),
                "action" => $action,
                "params" => json_encode($params),
                "sid" => $this->session->getData("sid"),
                "id" => $this->session->getData("id"),
                "log" => Application::getInstance()->log->getAsText(),
            ]);

            $this->document->render();
        }
    }