<?php

    namespace app\core;
    use app\enums\Annotation;
    use app\exceptions\MethodNotAllowedException;
    use app\exceptions\NotFoundException;
    use app\utils\AnnotationHandler;
    use ReflectionClass;

    class Router{
        public function resolveRoute($routes, $requestPath, $requestMethod):Route {
            $pathExists = false;
            foreach ($routes as $routeClass) {
                $reflectionClass = new ReflectionClass($routeClass);
                $docComment = $reflectionClass->getDocComment();
                if ($docComment) {
                    $routePath = AnnotationHandler::getAnnotation($docComment, Annotation::ROUTE);
                    if (!str_ends_with($routePath, '/')) {
                        $routePath .= '/';
                    }
                    if (!str_ends_with($requestPath, '/')) {
                        $requestPath .= '/';
                    }
                    if (str_starts_with($routePath, $requestPath)) {
                        foreach($reflectionClass->getMethods() as $method) {
                            $docComment = $method->getDocComment();
                            if ($docComment) {
                                $path = AnnotationHandler::getAnnotation($docComment, Annotation::PATH);
                                $httpMethod = AnnotationHandler::getAnnotation($docComment, Annotation::METHOD);

                                if ($path && $httpMethod) {
                                    if (str_starts_with($path, '/')) {
                                        $path = substr($path, 1);
                                    }
                                    $routePath .= $path;

                                    if ($routePath === $requestPath) {
                                        $pathExists = true;

                                        if ($requestMethod == $httpMethod) {
                                            return new Route($routeClass, $method->getName());
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (!$pathExists) {
                throw new NotFoundException('No existing path.');
            } else {
                throw new MethodNotAllowedException("There's no method $requestMethod for this path.");
            }
        }
    }
