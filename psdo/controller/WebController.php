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


        public function __construct() {
            parent::__construct();

            $this->document = HtmlDocument::getInstance();
        }

        protected function remove() {
            $s = Session::getInstance();
            //$s->startOrResume(["userId" => "222"]);
            //$s->stop();
        }

        protected function index($params = []) {
            $s = Session::getInstance();
            //$s->startOrResume(["userId" => "222"]);
            //$temp = new UserModel();
            //$temp

            //echo "sid: ".$s->sid."<br />";
            //echo "userid (fake): ".$s->userId;



            $a = new Widget("Debug/DebugBot", [
                "controller" => get_called_class(),
                "action" => __FUNCTION__,
                "params" => json_encode($params),
                "sid" => $s->sid,
                "log" => Application::getInstance()->log->getAsText(),
            ]);

            $this->document->writeRaw($a);
            $this->document->render();
        }

        public function runAction($action, $params = []) {
            switch ($action) {
                case "remove": {
                    $this->remove();
                break;
                }

                default: {
                    $this->index($params);
                break;
                }
            }
        }
    }