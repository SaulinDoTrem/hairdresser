<?php

    namespace app\core;

    class Response {
        protected function setStatusCode(int $code) {
            http_response_code($code);
        }
        public function sendResponse(int $httpStatusCode, string $message,array $data = null) {
            $this->setStatusCode($httpStatusCode);
            $this->setResponseHeaders();
            die(json_encode(["message"=> $message,"data"=>$data]));
        }

        protected function setResponseHeaders() {
            header("Content-Type:application/json;charset=utf-8");
        }
    }
?>