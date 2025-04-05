<?php
    require __DIR__.'/../vendor/autoload.php';

    use app\controllers\AuthController;
    use app\controllers\UserController;
    use Dotenv\Dotenv;
    use app\core\Application;

    $dotenv = Dotenv::createImmutable(__DIR__."\\..");
    $dotenv->safeLoad();

    $app = new Application(dirname(__DIR__), $_ENV);
    unset($_ENV);

    const ROUTES = [
        UserController::class,
        AuthController::class,
    ];

    $app->run(ROUTES);
    //TODO usar register_shutdown_function para não dropar erro inesperado