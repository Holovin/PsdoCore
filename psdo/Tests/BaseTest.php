<?php
    namespace PSDO\Tests;
    
    
    abstract class BaseTest {
        protected $result;
        protected $testData;

        public function __construct() {
            $this->Reset();
            $this->RunTest();
            $this->GetResult();
        }

        private function GetResult() {
            var_dump($this->result);
            var_dump($this->testData);
        }

        protected function Reset() {
            $this->result = false;
            $this->testData = [];
        }

        protected function SetSuccess($value) {
            $this->result = true;
            $this->WriteData("Success", $value);
        }

        protected function WriteData($key, $value) {
            if (array_key_exists($key, $this->testData)) {
                $this->testData[$key] = $this->testData[$key].'\n'.$value;
                return;
            }

            $this->testData[$key] = $value;
        }

        protected function RunTest() {
            return;
        }
    }