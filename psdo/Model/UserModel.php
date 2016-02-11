<?php
    namespace PSDO\Model;

    class UserModel extends BaseModel {
        /** @var int PsdoID */
        private $id = null;

        private $socialTypeId = null;

        /** @var int Socal network user id */
        private $socialId = null;

        /** @var string Params part for autologin without social  */
        private $authFastKey = null;

        public function __construct() {
            parent::__construct();
        }
    }