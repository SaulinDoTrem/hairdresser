<?php

    namespace Hairdresser\Utils;
    class Config {
        public static function httpRequest(string $message, int $httpCode, array $data = null) {
            http_response_code($httpCode);
            header("Content-Type:application/json;charset=utf-8");
            die(json_encode(["message"=>$message,"dados"=>$data]));
        }
    }
?>