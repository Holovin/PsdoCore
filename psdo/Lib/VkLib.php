<?php
    namespace PSDO\Lib;

    use PSDO\Config\VkConfig;
    use PSDO\Lib\CurlLib;

    class VkLib {
        public $config = null;
        private $lastAnswer = null;

        public function __construct() {
            $this->config = VkConfig::getInstance();
        }

        public function resetData() {
            $this->lastAnswer = null;
        }

        public function getAuthLink() {
            return "https://oauth.vk.com/authorize?client_id=".$this->config->client_id.
                   "&display=popup".
                   "&redirect_uri=".$this->config->callback_uri.
                   "&response_type=code".
                   "&v=".$this->config->ver;
        }

        public function getTokenFromAuthCode($code) {
            $this->resetData();
            $curl = new CurlLib();

            if (!$curl->getLastError()["code"]) {
                $link = $this->getTokenLink($code);
                $this->lastAnswer = $this->processAnswer($curl->httpGet($link)->getData());
            }
        }

        private function processAnswer($answer) {
            return json_decode($answer);
        }

        public function getLastError() {
            if (!empty($this->lastAnswer) && !empty($this->lastAnswer->error)) {
                return array(
                    "code" => $this->lastAnswer->error,
                    "text" => $this->lastAnswer->error_description);
            }
            return false;
        }

        public function getLastAnswer() {
            return $this->lastAnswer;
        }

        private function getTokenLink($code) {
            return "https://oauth.vk.com/access_token?client_id=".$this->config->client_id.
                   "&client_secret=".$this->config->client_secret.
                   "&redirect_uri=".$this->config->callback_uri.
                   "&code=".$code;
        }

        public function __get($key) {
            if (!empty($this->lastAnswer->$key)) {
                return $this->lastAnswer->$key;
            }

            return null;
        }
    }