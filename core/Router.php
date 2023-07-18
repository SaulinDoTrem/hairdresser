<?php

    namespace app\core;
    use app\controllers\testaController;
    use ReflectionClass;
    use Reflector;

    class Router{
        private Request $request;
        private Response $response;
        protected array $routes = [];
        public function __construct(Request $request, Response $response) {
            $this->setRequest($request);
            $this->setResponse($response);
        }
        public function setResponse(Response $response):void {
            $this->response = $response;
        }
        public function getRequest(): Request {
            return $this->request;
        }
        public function setRequest(Request $request):void {
            $this->request = $request;
        }
        public function registerRoute($classNamespace):void {
            $reflector = new ReflectionClass($classNamespace);
            $classInstance = $reflector->newInstance();

            $this->routes[$classInstance->getPath()] = $classInstance;
        }
        public function resolve():array {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();

            if(empty($this->routes[$path]))
                return ["code"=> 404, "message"=> "No existing path.", "data"=> null];
            $classInstance = $this->routes[$path];

            $requestData = $this->request->getData();

            return $classInstance->{$method}($requestData);
        }
    }
?>