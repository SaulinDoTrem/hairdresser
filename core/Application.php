<?php

    namespace app\core;
    use app\core\Router;
    use app\exceptions\HttpException;
    use app\exceptions\InternalServerException;
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

        public function run():void {
            try {
                //TODO pensar num roteamento melhor
                // talvez não precise registrar as rotas só procurar qual bate
                // talvez colocar a rota primária na classe primeira e a secundária na função
                // mais aí e se uma controladora tiver uma função que não é uma rota?
                // pensar em como vai ser feito
                $route = $this->router->resolveRoute(
                    $this->request->getPath(),
                    $this->request->getMethod()->value
                );
                $method = $route->getMethodName();
                $controller = $this->instanceController($route);
                $this->response = $controller
                    ->{$method}($this->request, $this->response);
                $this->response->sendResponse();
            } catch (Throwable $e) {
                // throw $e;
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
                // se for a DAO tem que criar o PDO antes
                $parameterInstances[] = new ($parameter->getType()->getName())();
            }

            return $r->newInstanceArgs($parameterInstances);
        }

        public function getRouter():Router {
            return $this->router;
        }
    }