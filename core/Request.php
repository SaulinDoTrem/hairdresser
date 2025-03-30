<?php

    namespace app\core;
    use app\enums\HttpMethod;

    class Request {
        public function getPath():string {
            return strtolower($_SERVER["REQUEST_URI"]) ?? '/';
        }
        public function getMethod():HttpMethod {
            return HttpMethod::from(strtoupper($_SERVER["REQUEST_METHOD"]));
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
                [$key, $value] = explode("=",$argument);
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                $requestData[$key] = $value === '' || $value === null ? null : $value;
            }

            return $requestData;
        }
        public function getData():array {
            $method = $this->getMethod();

            if ($method->hasBody()) {
                return $this->getBody();
            } else {
                return $this->getURIArguments();
            }
        }
    }
