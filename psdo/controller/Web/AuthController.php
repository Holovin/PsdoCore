<?php
    namespace PSDO\Controller\Web;

    use PSDO\Core\Application;
    use PSDO\Enums\Session\SessionState;
    use PSDO\Enums\Session\SessionSocial;
    use PSDO\Lib\VkLib;
    use PSDO\Controller\WebController;
    use PSDO\Model\UserModel;

    class AuthController extends WebController {
        protected $routes = [
            "vkL12332ogin" => "vkLoginAction"
            ];

        public function __construct() {
            parent::__construct();
        }

        protected function indexAction($params = []) {
            $this->document->writeRaw("This is AuthController !");
            echo $_SERVER["HTTP_HOST"]."<br />";
            echo $_SERVER["SERVER_NAME"]."<br />";
        }

        protected function vkCallbackAction($params = []) {
            $vkLib = new VkLib();

            $this->user = new UserModel();


            if (!empty($params["code"])) {
                $vkLib->getTokenFromAuthCode($params["code"]);

                if (!$vkLib->getLastError()) {
                    $data["sid"] = null;
                    $data["state"] = SessionState::Auth;

                    $data["socialType"] = SessionSocial::Vk;
                    $data["socialId"] = $vkLib->user_id;
                    $data["socialToken"] = $vkLib->access_token;

                    $data["userAgent"] = $_SERVER['HTTP_USER_AGENT'];
                    $data["ip"] = $_SERVER["REMOTE_ADDR"];

                    $data["startTime"] = date('Y-m-d h:i:s', time());
                    $data["expires"] = $vkLib->expires_in;

                    $data["userId"] = 666;

                    if ($this->user->load($data["socialType"], $data["socialId"])) {
                        Application::getInstance()->log->add("FOUND USER!");
                    } else {
                        Application::getInstance()->log->add("NOT FOUND USER!");
                        $this->register($params);
                    }

                    $this->session->stop();
                    return $this->session->start($data);
                }
            }

            $this->redirect("http://localhost/?emptyCode");
            return "";
        }

        protected function register($params = []) {
            //$this->document->writeRaw("Введите свои данные:");
        }

        protected function vkLoginAction($params = []) {
            if ($this->session->getState() == SessionState::Guest) {
                $vkLib = new VkLib();
                $link = $vkLib->getAuthLink();
                $this->redirect($link);
                return true;
            } else if ($this->session->getState() == SessionState::Auth) {
                // TODO: redirect
                return true;
            }
            return true;
        }

        protected function logoutAction($params = []) {
            if ($this->session->getState() != SessionState::Guest && $this->session->stop()) {
                //$this->document->writeRaw("Stopped ok!");
            }
        }
    }