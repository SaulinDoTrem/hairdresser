<?php

    namespace app\core;

    class Router {
        public Request $request;
        protected array $routes = [];
        public function __construct(Request $request) {
            $this->setRequest($request);
        }
        public function getRequest(): Request {
            return $this->request;
        }
        public function setRequest(Request $request):void {
            $this->request = $request;
        }
        public function get($path, $callback):void {
            $this->routes['get'][$path] = $callback;
        }
        public function resolve():void {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();
            $callback = $this->routes[$method][$path] ?? false;
            if($callback === false) die("Not found");
            echo call_user_func($callback);
        }
    }
?>