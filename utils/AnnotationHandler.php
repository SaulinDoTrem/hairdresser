<?php

    namespace app\utils;
    use app\enums\Annotation;
    use ReflectionClass;

    class AnnotationHandler {
        public static function getAnnotation(string $docComment, Annotation $annotation):string|bool {
            $value = null;
            if ($annotation->matches($docComment, $value)) {
                return $value;
            }
            return false;
        }

        public static function getDocComment(ReflectionClass $reflectionClass):string {
            $docComment = '';
            do {
                $doc = $reflectionClass->getDocComment();
                if ($doc) {
                    $docComment .= $doc;
                }
                $reflectionClass = $reflectionClass->getParentClass();
            }while($reflectionClass);
            return $docComment;
        }

        public static function hasAnnotation(string $docComment, Annotation $annotation) {
            return mb_strpos($docComment, $annotation->value) !== false;
        }
    }