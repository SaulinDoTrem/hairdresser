<?php

    namespace Hairdresser\Utils;
    use Dotenv\Dotenv;

    class Config {
        public static function httpRequest(string $message, int $httpCode, array $data = null) {
            http_response_code($httpCode);
            if($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
                header("HTTP/1.1 200 OK");
            }
            header('Access-Control-Allow-Credentials: true');
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET,OPTIONS,PATCH,DELETE,POST,PUT");
            header("Access-Control-Allow-Headers: X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version, Authorization");
            header("Content-Type:application/json;charset=utf-8");
            die(json_encode(["message"=>$message,"data"=>$data]));
        }

        public static function startDotEnv() {
            if(empty($_ENV)) {
                $dotenv = Dotenv::createImmutable(__DIR__."\\..\\..");
                $dotenv->safeLoad();
            }
        }

        public static function expectedData(array $arrayExpectedData, array $arrayData=null) {
            $httpCodeError = 400;
            if(empty($arrayData))
                Config::httpRequest("Json vazio ou nulo.", $httpCodeError);

            $emptyData = [];

            foreach($arrayExpectedData as $key => $value) {
                if(empty($arrayData[$value])) {
                    array_push($emptyData, $value);
                }

            }

            if(!empty($emptyData))
                Config::httpRequest("O(s) seguinte(s) dado(s) estava(m) vazio(s): " . implode(", ", $emptyData), $httpCodeError);
        }
    }
?>