<?php

    namespace app\connectors;
    use app\exceptions\InternalServerException;
    use app\utils\Settings;
    use PDO;
    use PDOException;

    class MySqlConnector implements DatabaseConnector{
        public function getConnection():PDO {
            $host = Settings::$DB_HOST;
            $dbname = Settings::$DB_NAME;
            $user = Settings::$DB_USER;
            $password = Settings::$DB_PASSWORD;
            $charset = Settings::$DB_CHARSET;
            try {
                $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;";
                return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
            } catch(PDOException $e) {
                throw new InternalServerException('An unexpected error occurred trying to comunicate with database.', 0, $e);
            }
        }
    }