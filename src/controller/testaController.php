<?php
    require __DIR__.'/../../vendor/autoload.php';

    use Dotenv\Dotenv;
    use Hairdresser\Controller\Database;
    use Hairdresser\Model\FederativeUnit;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $inputPost = file_get_contents("php://input");
    $json = json_decode($inputPost, true);

    $dotenv = Dotenv::createImmutable(__DIR__."/../..");
    $dotenv->load();

    $inputDotEnv = 'DATABASE_';
    $b = ["host"=>$_ENV["{$inputDotEnv}HOST"],
    "dbname"=>$_ENV["{$inputDotEnv}NAME"],
    "user"=>$_ENV["{$inputDotEnv}USER"],
    "password"=>$_ENV["{$inputDotEnv}PASSWORD"]];

    $city = new FederativeUnit();

    $city->fromMap([
        "id"=> 1,
        "name"=> "getName()",
        "acronym"=> "()"
    ]);

    $database = new Database($city);

    $a = $database->select(array_keys($city->toMap()));

    $key = $_ENV["TOKEN_JWT_KEY"];
    $payload = [
        "exp" => time() + 86400, // 1 day of expiring time
        "iat" => time(), // token create date
        "key" => $json["teste"]
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    $newKey = new Key($key, 'HS256');
    $decoded = JWT::decode($jwt, $newKey);
    $headers = new stdClass();
    $jwt2 = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE2ODkzNjk0NzUsImlhdCI6MTY4OTI4MzA3NSwia2V5Ijoic2F1bGluIERvIFRyZW0ifQ.DiQmSnSGy2vDJSIcHYTom6W0tlk1saMkxBbbO60eRxo";
    try {
        $decoded = JWT::decode($jwt2, $newKey, $headers);
    } catch (LogicException | UnexpectedValueException $e) {
        // errors having to do with environmental setup or malformed JWT Keys
        die("erro {$e->getMessage()}");
    }

    header("Content-Type:application/json;charset=utf-8");
    die(json_encode(["versão"=>phpversion(),"token"=>$jwt,"tokenValido"=>$decoded,"json_recebido"=>$json, "database"=>$a,"b"=>$b]));
?>