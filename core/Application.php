<?php

    namespace app\core;
    use app\core\Router;

    class Application {
        public static string $ROOT_DIR;
        private Router $router;
        private Request $request;
        private Response $response;
        //public
        public function __construct(string $rootPath) {
            self::$ROOT_DIR = $rootPath;
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router($this->request, $this->response);
        }
        public function run():void {
            $this->router->resolve();
        }
        public function getRouter():Router {
            return $this->router;
        }
    }
?>