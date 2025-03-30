<?php

    namespace app\factories;
    use app\exceptions\InternalServerException;
    use PDO;
    use PDOException;

    class ConnectionFactory {
        public static function getConnection($host, $dbname, $user, $password):PDO {
            try {
                $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";
                return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
            } catch(PDOException $e) {
                throw new InternalServerException('An unexpected error occurred trying to comunicate with database.', 0, $e);
            }
        }
    }