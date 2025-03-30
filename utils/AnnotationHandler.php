<?php

    namespace app\utils;
    use app\enums\Annotation;

    class AnnotationHandler {
        public static function getAnnotation(string $docComment, Annotation $annotation):string|bool {
            $value = null;
            if ($annotation->matches($docComment, $value)) {
                return $value;
            }
            return false;
        }
    }