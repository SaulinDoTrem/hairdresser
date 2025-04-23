<?php

    namespace app\views;
    use app\enums\HttpStatus;
    use app\exceptions\HttpException;
    use app\models\ControllerResponse;

    class Response {
        private HttpStatus $statusCode;
        private array $data = [];

        public function setStatusCode(HttpStatus $statusCode):void {
            $this->statusCode = $statusCode;
        }

        public function setData(array $data):void {
            $this->data = $data;
        }

        private function setResponseStatusCode() {
            http_response_code($this->statusCode->value);
        }

        public function sendErrorResponse(HttpException $e):void {
            // pegar o status code da Exception -> talvez criar uma classe HttpExcetion com um atributo de status code, caso não tenha sido preenchido ele será 500
            $this->setStatusCode($e->getStatusCode());
            $this->setData(['message' => $e->getMessage()]);
            $this->sendResponse();
        }

        public function sendResponse():never {
            $this->setResponseStatusCode();
            $this->setResponseHeaders();
            die($this->encodeResponse());
        }

        private function encodeResponse():string {
            return json_encode($this->data);
        }

        private function setResponseHeaders():void {
            header("Content-Type:application/json; charset=utf-8");
        }

        public function cast(ControllerResponse $response) {
            $this->setData($response->getData());
            $this->setStatusCode($response->getHttpStatus());
        }
    }
