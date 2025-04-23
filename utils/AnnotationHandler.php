<?php

    namespace app\utils;
    use app\enums\Annotation;
    use ReflectionClass;
    use ReflectionProperty;

    class AnnotationHandler {
        public static function getAnnotation(string $docComment, Annotation $annotation, &$offset = 0):string|bool {
            $value = null;
            if ($annotation->matches($docComment, $value, $offset)) {
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

        public static function getColumnName(ReflectionProperty $columnProperty, string $docComment) {
            $matches = Annotation::COLUMN->matches($docComment, $columnName);
            if ($matches) {
                return $columnName;
            }
            return $columnProperty->getName();
        }

        public static function getAllAnnotations(string $docComment, Annotation $annotation) {
            $offset = 0;
            $annotations = [];
            do {
                $value = self::getAnnotation($docComment, $annotation, $offset);
                if ($value !== false) {
                    $annotations[] = explode(',', $value);
                }
            }while($value !== false);
            return $annotations;
        }
    }