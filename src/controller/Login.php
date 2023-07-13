<?php

    require __DIR__.'/../../vendor/autoload.php';

    use Hairdresser\Controller\Database;
    use Hairdresser\Model\Person;
    use Firebase\JWT\JWT;
    use Dotenv\Dotenv;
    use Hairdresser\Utils\Config;


    $dotenv = Dotenv::createImmutable(__DIR__."/../..");
    $dotenv->load();



    $inputJson = file_get_contents("php://input");
    $jsonData = json_decode($inputJson, true);

    $person = new Person();

    $database = new Database($person->getTableName());

    $jsonData["password"] = hash("sha256",$jsonData["password"]);

    $where = implode(" = ? and ", array_keys($jsonData)) . " = ?";

    $result = $database->select($person->getColumns(), $where, array_values($jsonData));
    if(count($result)>0) {
        $person->fromMap($result[0]);

        $key = $_ENV["TOKEN_JWT_KEY"];
        $payload = [
            "exp" => time() + 86400, // 1 day of expiring time
            "iat" => time(), // token create date
            "key" => $person->toMap()
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        Config::httpRequest("User sucessful authenticaded.", 200, ["token"=>$jwt]);
    }
    Config::httpRequest("Person not foud.", 404);
?>