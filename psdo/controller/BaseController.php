<?php
    namespace PSDO\Controller;

    use PSDO\Core\Application;
    use PSDO\Storage\Database;
    use PSDO\Storage\Session;
    use PSDO\View\Documents\HtmlDocument;
    use PSDO\Model\UserModel;
    use PSDO\View\Widget;

    class BaseController {
        /** @var Database */
        protected $db = null;

        public function __construct() {
            $this->db = Database::getInstance();
        }

        protected function index($params = []) {
            //
        }

        public function runAction($action, $params = []) {
            switch ($action) {
                default: {
                    $this->index($params);
                    break;
                }
            }
        }
    }