<?php

    namespace app\models;

    use app\enums\HttpStatus;

    class ControllerResponse {
        private HttpStatus $httpStatus;
        private array $data;

        public function __construct(
            HttpStatus $httpStatus,
            array $data
        ) {
            $this->httpStatus = $httpStatus;
            $this->data = $data;
        }

        public function getHttpStatus() {
            return $this->httpStatus;
        }

        public function getData() {
            return $this->data;
        }
    }