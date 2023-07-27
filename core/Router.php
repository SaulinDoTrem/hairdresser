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
            $methods = $reflector->getMethods();
            $path = $reflector->getConstant("PATH");

            foreach($methods as $method) {
                $name = $method->getName();
                if(in_array($name, ['get','post','put','delete', 'options', 'patch']))
                    $this->routes[$path][$name] = $classNamespace;
            }
        }
        public function resolve():void {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();

            if(empty($this->routes[$path])) {
                $this->response->sendResponse(404, "No existing path.");
                return;
            }
            if(empty($this->routes[$path][$method])) {
                $method = strtoupper($method);
                $this->response->sendResponse(404, "There's no method $method for this path.");
                return;
            }
            $reflector = new ReflectionClass($this->routes[$path][$method]);
            $classInstance = $reflector->newInstance();

            $requestData = $this->request->getData();

            ["code"=> $code, "message"=> $message, "data"=> $responseBody] = $classInstance->{$method}($requestData);

            $this->response->sendResponse($code, $message, $responseBody);
        }
    }
?>