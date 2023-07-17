<?php

    require __DIR__.'/../../vendor/autoload.php';

    use Hairdresser\Controller\Database;
    use Hairdresser\Model\Person;
    use Firebase\JWT\JWT;
    use Hairdresser\Utils\Config;


    Config::startDotEnv();

    $inputJson = file_get_contents("php://input");
    $jsonData = json_decode($inputJson, true);

    $arrayExpectedData = [
        "user_name",
        "password"
    ];

    Config::expectedData($arrayExpectedData, $jsonData);

    $person = new Person();

    $database = new Database($person->getTableName());

    $jsonData["password"] = hash($_ENV["ENCRYPT_ALGO"],$jsonData["password"]);

    $where = "WHERE " . implode(" = ? and ", array_keys($jsonData)) . " = ?";

    $result = $database->select([], $where, array_values($jsonData));
    if(count($result)>0) {
        $person->fromMap($result[0]);

        $key = $_ENV["TOKEN_JWT_KEY"];
        $payload = [
            "exp" => time() + 86400, // 1 day of expiring time
            "iat" => time(), // token create date
            "person" => $person->toMap()
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        Config::httpRequest("User sucessful authenticaded.", 200, ["token"=>$jwt]);
    }
    Config::httpRequest("Person not foud.", 404);
?>