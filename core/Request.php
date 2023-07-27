<?php

    namespace app\core;

    class Request {
        public function getPath():string {
            return $_SERVER["PATH_INFO"] ?? '/';
        }
        public function getMethod():string {
            return strtolower($_SERVER["REQUEST_METHOD"]);
        }
        protected function getBody():array {
            $inputJson = file_get_contents("php://input");
            return json_decode($inputJson, true);
        }

        protected function getURIArguments():array {
            $requestData = [];
            $arguments = explode("?", $_SERVER["REQUEST_URI"])[1] ?? "";

            if($arguments === "")
                return $requestData;

            $arguments = explode("&", $arguments);
            foreach($arguments as $argument) {
                $explodeArray = explode("=",$argument);
                if(count($explodeArray)>1){
                    [$key, $value] = explode("=",$argument);
                    $requestData[$key] = $value;
                }
            }

            return $requestData;
        }
        public function getData():array {
            $method = $this->getMethod();

            if(in_array($method, ["delete", "get"])) {
                return $this->getURIArguments();
            }
            if(in_array($method, ["put", "post"])) {
                return $this->getBody();
            }

            return [];
        }
    }
?>