<?php

    namespace app\views;
    use app\enums\HttpMethod;
    use app\core\Path;

    class Request {
        private Path $path;
        private HttpMethod $method;

        public function __construct() {
            $this->path = new Path(strtolower($_SERVER["REQUEST_URI"]) ?? '/');
            $this->method = HttpMethod::from(strtoupper($_SERVER["REQUEST_METHOD"]));
        }

        public function getPath():Path {
            return $this->path;
        }
        public function getMethod():HttpMethod {
            return $this->method;
        }
        protected function getBody():array {
            $inputJson = file_get_contents("php://input");
            return json_decode($inputJson, true);
        }

        protected function getURIArguments():array {
            $requestData = [];
            $arguments = explode("?", $this->path->getPath())[1] ?? "";

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
            if ($this->method->hasBody()) {
                return $this->getBody();
            } else {
                return $this->getURIArguments();
            }
        }
    }
