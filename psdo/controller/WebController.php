<?php
    namespace PSDO\Controller;

    use PSDO\Core\Application;
    use PSDO\Storage\Database;
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

        /** @var array Routes map, ex. "action-super-2015" => "indexAction" */
        protected $routes = ["zhum" => "removeAction"];

        public function __construct() {
            parent::__construct();

            //$this->session = new Session();
            //$this->session->startOrResume();
        }

        protected function redirect($urlTo, $code = 301) {
            header("Location: ".$urlTo, true, $code);
        }

        protected function removeAction() {
            //$s->startOrResume(["userId" => "222"]);
            //$s->stop();
            $this->redirect("http://vk.com");
        }

        protected function indexAction($params = []) {
            $this->document->writeRaw("index ".json_encode($params));
        }

        public function run($action, $params = []) {
            $this->document = HtmlDocument::getInstance();

            if (isset($this->routes['$action'])) {
                // check map 1st
                $this->{$this->routes[$action]}($params);
            } else if (method_exists($this, $action."Action")) {
                // run directly
                $this->{$action."Action"}($params);
            } else {
                // run default
                $this->indexAction($params);
            }

            // DEBUG //
            $a = new Widget("Debug/DebugBot", [
                "controller" => get_called_class(),
                "action" => $action,
                "params" => json_encode($params),
                "sid" => "а ты сессии сделай сначала",//$this->session->sid,
                "log" => Application::getInstance()->log->getAsText(),
            ]);

            $this->document->writeRaw($a);
            $this->document->render();
        }
    }