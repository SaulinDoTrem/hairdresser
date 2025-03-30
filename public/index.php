<?php
    require __DIR__.'/../vendor/autoload.php';

    use app\controllers\AuthController;
    use app\controllers\UserController;
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

    const ROUTES = [
        UserController::class,
        AuthController::class,
    ];

    $app->run(ROUTES);
    //TODO usar register_shutdown_function para não dropar erro inesperado