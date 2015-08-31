<?php
    namespace PSDO\Lib;
    
    
    class CurlLib {
        const userAgent = "Mozilla/5.0 (PSDO bot)";

        private $curl = null;

        private $requestData = [];
        private $lastErrorCode = 0;
        private $lastErrorText = null;
        public  $lastHttpCode = 0;

        /** @var String */
        private $answerData = null;

        public function __construct($ssl = true, $timeout = 30, $userAgent = self::userAgent) {
            if ($this->curl = curl_init()) {
                curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $timeout);
                curl_setopt($this->curl, CURLOPT_USERAGENT, $userAgent);
            }
            $this->lastErrorCode = curl_errno($this->curl);
        }

        public function httpGet($link) {
            $this->query($link);
            return $this;
        }

        public function getDataJson() {
            return json_decode($this->answerData, true);
        }

        public function getData() {
            return $this->answerData;
        }

        public function getLastError() {
            return array(
                "code" => $this->lastErrorCode,
                "text" => $this->lastErrorText);
        }

        public function httpPostAddData($key, $value) {
            $this->requestData[$key] = $value;

            return $this;
        }

        public function httpPostResetData() {
            $this->requestData = [];
        }

        public function httpPost($link) {
            $postData = "";

            foreach ($this->requestData as $key => $value) {
                $postData .= $key."=".$value."&";
            }

            rtrim($postData, "&");

            $this->query($link, $postData);
            $this->httpPostResetData();
            return $this;
        }

        private function resetData() {
            $this->lastHttpCode = 0;
            $this->lastErrorCode = 0;
            $this->lastErrorText = null;
            $this->requestData = [];
            $this->answerData = null;
        }

        private function query($link, $postData = '') {
            if (!empty($postData)) {
                curl_setopt($this->curl, CURLOPT_POST, true);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postData);
            }

            if (!empty($link)) {
                $this->resetData();

                curl_setopt($this->curl, CURLOPT_URL, $link);
                $this->answerData = curl_exec($this->curl);
                $this->lastErrorCode = curl_errno($this->curl);
                $this->lastErrorText = curl_error($this->curl);
                $this->lastHttpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
            }
        }
    }