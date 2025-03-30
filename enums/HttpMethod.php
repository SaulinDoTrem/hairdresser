<?php
    namespace app\enums;

    enum HttpMethod: string{
        case POST = 'POST';
        case GET = 'GET';
        case PUT = 'PUT';
        case DELETE = 'DELETE';

        public function hasBody():bool {
            return match($this) {
                HttpMethod::POST, HttpMethod::PUT => true,
                HttpMethod::DELETE, HttpMethod::GET => false,
            };
        }
    }