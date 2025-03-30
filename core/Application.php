<?php

    namespace app\core;
    use app\core\Router;
    use app\daos\Dao;
    use app\exceptions\HttpException;
    use app\exceptions\InternalServerException;
    use app\factories\ConnectionFactory;
    use ReflectionClass;
    use Throwable;

    class Application {
        public static string $ROOT_DIR;
        public static array $CONFIG;
        private Router $router;
        private Request $request;
        private Response $response;
        public function __construct(string $rootPath, array $config) {
            self::$ROOT_DIR = $rootPath;
            self::$CONFIG = $config;
            $this->request = new Request();
            $this->response = new Response();
            $this->router = new Router();
        }

        public function run(array $routes):void {
            try {
                $route = $this->router->resolveRoute(
                    $routes,
                    $this->request->getPath(),
                    $this->request->getMethod()->value
                );
                $method = $route->getMethodName();
                $controller = $this->instanceController($route);
                $controller
                    ->{$method}($this->request, $this->response);
                $this->response->sendResponse();
            } catch (Throwable $e) {
                throw $e;
                //TODO botar verificação de ambiente pra mostrar o erro
                if (!$e instanceof HttpException) {
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

        private function instanceController(Route $route) {
            $class = $route->getClassNamespace();

            $r = new ReflectionClass($class);

            $constructParameters = $r
                ->getMethod('__construct')
                ->getParameters();

            $parameterInstances = [];
            foreach ($constructParameters as $parameter) {
                $parameterName = $parameter->getType()->getName();

                $class = $parameterName === Dao::class
                    ? new $parameterName($this->instanceDatabase())
                    : new $parameterName();
                $parameterInstances[] = $class;
            }

            return $r->newInstanceArgs($parameterInstances);
        }

        private function instanceDatabase():Database {
            $connection = ConnectionFactory::getConnection(
                $_ENV['DB_HOST'],
                $_ENV['DB_NAME'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
            );
            return new Database($connection);
        }

        public function getRouter():Router {
            return $this->router;
        }
    }