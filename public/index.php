<?php
    require __DIR__.'/../vendor/autoload.php';
    use app\controllers\testaController;
    use Dotenv\Dotenv;
    use app\core\Application;

    $dotenv = Dotenv::createImmutable(__DIR__."\\..");
    $dotenv->safeLoad();

    $config = [
        "dbname" => $_ENV["DB_NAME"],
        "host" => $_ENV["DB_HOST"],
        "user" => $_ENV["DB_USER"],
        "jwt_key" => $_ENV["TOKEN_JWT_KEY"],
        "password" => $_ENV["DB_PASSWORD"],
        "encrypt_algo" => $_ENV["ENCRYPT_ALGO"]
    ];

    $app = new Application(dirname(__DIR__), $config);

    $routes = [
        testaController::class
    ];

    foreach($routes as $route) {
        $app->getRouter()->registerRoute($route);
    }

    $app->run();
?>