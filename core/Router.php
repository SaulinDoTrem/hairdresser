<?php

    namespace app\core;
    use app\enums\Annotation;
    use app\enums\HttpMethod;
    use app\exceptions\MethodNotAllowedException;
    use app\exceptions\NotFoundException;
    use app\routes\Route;
    use app\utils\AnnotationHandler;
    use ReflectionClass;
    use ReflectionMethod;

    class Router{
        private ReflectionMethod $routeMethod;
        public function getRouteMethod():ReflectionMethod {
            return $this->routeMethod;
        }
        public function resolveRoute(array $routes, Path $requestPath, HttpMethod $requestMethod):ReflectionClass {
            $route = $this->findRoute($routes, $requestPath, $requestMethod);
            if ($route === null) {
                throw new NotFoundException('No existing path.');
            } elseif ($route === false) {
                throw new MethodNotAllowedException("There's no method {$requestMethod->value} for this path.");
            }
            return $route;
        }

        private function findRoute(array $routes, Path $requestPath, HttpMethod $requestMethod):ReflectionClass|null|false {
            foreach ($routes as $routeClass) {
                $reflectionClass = new ReflectionClass($routeClass);
                $docComment = AnnotationHandler::getDocComment($reflectionClass);
                if ($docComment) {
                    $routePath = AnnotationHandler::getAnnotation($docComment, Annotation::ROUTE);
                    $routePath = new Path($routePath);
                    if ($requestPath->isSubPath($routePath)) {
                        foreach ($reflectionClass->getMethods() as $m) {
                            $doc = $m->getDocComment();
                            $httpMethod = AnnotationHandler::getAnnotation($doc, Annotation::METHOD);
                            if (is_string($httpMethod)) {
                                $httpMethod = HttpMethod::from($httpMethod);
                            }

                            if ($httpMethod === $requestMethod) {
                                $path = AnnotationHandler::getAnnotation($doc, Annotation::PATH);
                                $path = $routePath->concat($path);
                                if ($this->pathMatches($requestPath, $path)) {
                                    $this->routeMethod = $m;
                                    return $reflectionClass;
                                }
                            }
                        }
                        return false;
                    }
                }
            }
            return null;
        }

        private function pathMatches(Path $requestPath, Path $path):bool {
            return $requestPath->getPath() === $path->getPath();
        }
    }
