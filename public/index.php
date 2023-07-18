<?php
    require __DIR__.'/../vendor/autoload.php';
    use app\controllers\testaController;

    use app\core\Application;

    $app = new Application(dirname(__DIR__));

    $routes = [
        testaController::class
    ];

    foreach($routes as $route) {
        $app->getRouter()->registerRoute($route);
    }

    $app->run();
?>