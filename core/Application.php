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
            ["code"=> $code, "message"=> $message, "data"=> $responseData] = $this->router->resolve();
            $this->response->sendResponse($code, $message, $responseData);
        }
        public function getRouter():Router {
            return $this->router;
        }
    }
?>