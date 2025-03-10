<?php

    namespace app\core;
    use Exception;

    class Response {
        private function setResponseStatusCode($statusCode) {
            http_response_code($statusCode);
        }

        public function sendSuccessResponse(array $data):void {
            $this->sendResponse(200, $data);
        }

        public function sendErrorResponse(Exception $e):void {
            $this->sendResponse(500, ['message' => $e->getMessage()]);
        }

        private function sendResponse(int $statusCode, array $data):never {
            $this->setResponseStatusCode($statusCode);
            $this->setResponseHeaders();
            die($this->encodeResponse($data));
        }

        private function encodeResponse(array $data):string {
            return json_encode($data);
        }

        private function setResponseHeaders():void {
            header("Content-Type:application/json;charset=utf-8");
        }
    }
