<?php

    namespace app\core;
    use app\connectors\DatabaseConnector;
    use app\connectors\MySqlConnector;
    use app\core\Router;
    use app\exceptions\HttpException;
    use app\exceptions\InternalServerException;
    use app\utils\Settings;
    use app\views\Request;
    use app\views\Response;
    use ReflectionClass;
    use ReflectionMethod;
    use Throwable;

    class Application {
        const INTERFACES_INSTANCES = [
            DatabaseConnector::class => MySqlConnector::class
        ];
        public static string $ROOT_DIR;
        private Router $router;
        private Request $request;
        private Response $response;
        public function __construct(string $rootPath, array $config) {
            self::$ROOT_DIR = $rootPath;
            Settings::setConfig($config);
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router();
        }

        public function run(array $routes):void {
            try {
                $route = $this->router->resolveRoute(
                    $routes,
                    $this->request->getPath(),
                    $this->request->getMethod()
                );
                $routeMethod = $this->router->getRouteMethod();
                $response = $routeMethod->invokeArgs(
                    $this->instanceRoute($route),
                    $this->getRouteMethodArgs($routeMethod)
                );

                $this->response->cast($response);
                $this->response->sendResponse();
            } catch (Throwable $e) {
                if (!$e instanceof HttpException) {
                    if (Settings::$ENV == 'DEV') {
                        throw $e;
                    }
                    // TODO mascarar o erro antes de mandar a resposta
                    $e = new InternalServerException(
                        $e->getMessage(),
                        $e->getCode(),
                        $e
                    );
                }
                $this->response->sendErrorResponse($e);
            }
        }

        private function instanceRoute(ReflectionClass $route) {
            $params = $this->getConstructParams($route);
            return $route->newInstanceArgs($params);
        }

        private function getConstructParams(ReflectionClass $re) {
            $params = [];
            foreach($re->getConstructor()->getParameters() as $p) {
                $class = $p->getType();
                if ($class === null) {
                    die(var_dump('a', $re, $p->getType()));
                } else {
                    $class = $class->getName();
                }
                $r = new ReflectionClass($class);
                if ($r->isInterface()) {
                    $class = self::INTERFACES_INSTANCES[$class];
                    $r = new ReflectionClass($class);
                }
                $constructor = $r->getConstructor();
                if ($constructor === null || $constructor->getNumberOfParameters() == 0) {
                    $params[] = $r->newInstance();
                } else {
                    $params[] = $r->newInstanceArgs($this->getConstructParams($r));
                }
            }
            return $params;
        }

        private function getRouteMethodArgs(ReflectionMethod $method):array {
            return [];
        }
    }