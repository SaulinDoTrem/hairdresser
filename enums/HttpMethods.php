<?php
    namespace app\enums;

    enum HttpMethods: string{
        case POST = 'POST';
        case GET = 'GET';
        case PUT = 'PUT';
        case DELETE = 'DELETE';

        public function hasBody() {
            return match($this) {
                HttpMethods::POST, HttpMethods::PUT => true,
                HttpMethods::DELETE, HttpMethods::GET => false,
            };
        }
    }