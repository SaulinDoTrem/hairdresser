<?php

    namespace app\core;

    class Settings {
        public static $DB_NAME;
        public static $DB_HOST;
        public static $DB_USER;
        public static $DB_PASSWORD;
        public static $TOKEN_JWT_KEY;
        public static $USER_PASSWORD_ENCRYPT_ALGO;
        public static $USER_PASSWORD_PEPPER;
        public static $ENV;
        public static function setConfig(array $config):void {
            self::$DB_NAME = $config["DB_NAME"];
            self::$DB_HOST = $config["DB_HOST"];
            self::$DB_USER = $config["DB_USER"];
            self::$DB_PASSWORD = $config["DB_PASSWORD"];
            self::$TOKEN_JWT_KEY = $config["TOKEN_JWT_KEY"];
            self::$USER_PASSWORD_ENCRYPT_ALGO = $config["USER_PASSWORD_ENCRYPT_ALGO"];
            self::$USER_PASSWORD_PEPPER = $config["USER_PASSWORD_PEPPER"];
            self::$ENV = $config['ENV'];
        }
    }