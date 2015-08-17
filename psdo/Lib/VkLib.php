<?php
    namespace PSDO\Lib;

    use PSDO\Config\VkConfig;

    class VkLib {
        public $config = null;

        public function __construct() {
            $this->config = VkConfig::getInstance();
        }

        public function getAuthLink($callbackUri) {
            return "https://oauth.vk.com/authorize?client_id=".$this->config->client_id.
                   "&display=popup".
                   "&client_secret=".$this->config->client_secret.
                   "&redirect_uri=$callbackUri".
                   "&response_type=code".
                   "&v=".$this->config->ver;
        }
    }