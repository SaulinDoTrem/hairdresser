<?php
    require __DIR__.'/../vendor/autoload.php';

    use app\core\Application;


    $app = new Application();

    $app->router->get('/', function() {
        return "hello world";
    });

    $app->router->get('/users', function(){
        return "users";
    });


    $app->run();
    //var_dump($_SERVER);
?>