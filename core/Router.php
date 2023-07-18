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
        public function registerRoute($classNamespace) {
            $reflector = new ReflectionClass($classNamespace);
            $classInstance = $reflector->newInstance();

            $this->routes[$classInstance->getPath()] = $classInstance;
        }
        public function resolve():void {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();

            $classInstance = $this->routes[$path];

            $requestData = $this->request->getData();

            ["code"=>$code, "message"=>$message, "data"=>$responseData] = $classInstance->{$method}($requestData);

            $this->response->sendResponse($code, $message, $responseData);
        }
    }
?>