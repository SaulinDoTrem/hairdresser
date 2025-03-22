<?php

    namespace app\core;
    use app\exceptions\InternalServerException;
    use app\exceptions\MethodNotAllowedException;
    use app\exceptions\NotFoundException;
    use ReflectionClass;

    class Router{
        /**
         * @var Route[]
         */
        protected array $routes = [];

        public function registerRoutes($routes):void {
            foreach ($routes as $classNamespace) {
                $reflector = new ReflectionClass($classNamespace);
                $routableMethodsQty = 0;
                foreach ($reflector->getMethods() as $method) {
                    $doc = $method->getDocComment();
                    $path = $this->extractRoutePath($doc);
                    $httpMethod = $this->extractRouteHttpMethod($doc);

                    if (!empty($path) && !empty($httpMethod)) { // TODO - verificar se o path e o método são válidos
                        $this->routes[$path][$httpMethod] = new Route(
                            $classNamespace,
                            $method->getName()
                    );
                        $routableMethodsQty++;
                    }
                }
                if ($routableMethodsQty == 0) {
                    throw new InternalServerException("The class $classNamespace need at least one route with path and HTTP method explicit.");
                }
            }
        }

        private function extractRoutePath($doc) {
            $matches = null;
            $match = preg_match('/@path\["(\/((\d|[a-z])+\/*)+)"]/', $doc, $matches);

            if ($match) {
                return $matches[1];
            }
            return null;
        }

        private function extractRouteHttpMethod($doc) {
            $matches = null;
            $match = preg_match('/@method\["([A-Z]+)"]/', $doc, $matches);
            if ($match) {
                return $matches[1];
            }
            return null;
        }

        public function resolveRoute($path, $method):Route {
            if(empty($this->routes[$path])) {
                throw new NotFoundException('No existing path.');
            }

            if(empty($this->routes[$path][$method])) {
                $method = strtoupper($method);
                throw new MethodNotAllowedException("There's no method $method for this path.");
            }

            return $this->routes[$path][$method];
        }
    }
