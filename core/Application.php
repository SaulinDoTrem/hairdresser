<?php

    namespace app\core;
    use app\core\Router;
    use ReflectionClass;
    use Exception;

    class Application {
        public static string $ROOT_DIR;
        public static array $CONFIG;
        private Router $router;
        private Request $request;
        private Response $response;
        //public
        public function __construct(string $rootPath, array $config) {
            self::$ROOT_DIR = $rootPath;
            self::$CONFIG = $config;
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router();
        }

        public function run():void {
            try {
                $route = $this->router->resolveRoute($this->request->getPath(), $this->request->getMethod());
                $controllerNamespace = $route->getClassNamespace();
                $controllerMethodName = $route->getMethodName();

                $controller = (new ReflectionClass($controllerNamespace))->newInstance();
                $data = $controller->{$controllerMethodName}($this->request);
                $this->response->sendSuccessResponse($data);
            } catch (Exception $e) {
                $this->response->sendErrorResponse($e);
            }
        }

        public function getRouter():Router {
            return $this->router;
        }
    }