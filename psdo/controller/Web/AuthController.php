<?php
    namespace PSDO\Controller\Web;

    use PSDO\Lib\VkLib;
    use PSDO\Controller\WebController;

    class AuthController extends WebController {

        public function __construct() {
            parent::__construct();
        }


        protected function indexAction($params = []) {
            $this->document->writeRaw("This is AuthController !");
        }

        protected function login2Action($params = []) {
            $vkLib = new VkLib();
            $link = $vkLib->getAuthLink("localhost/login/Callback");
            $this->redirect($link);
            // TODO на завтра: ловить редирект, делать нормальные ссылки, сделать обёртку для curl
            // TODO: сделать обработку ошибок (парсер!) в классе VkLib

        }
    }