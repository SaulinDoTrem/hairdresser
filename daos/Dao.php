<?php

    namespace app\daos;
    use app\core\Database;
    use app\enums\Annotation;
    use app\utils\AnnotationHandler;
    use Exception;
    use ReflectionClass;

    // DAO abstrata para inserir dados no banco utilizando reflexão e anotações nos objetos modelos
    abstract class Dao {
        private Database $db;
        public function __construct($db) {
            $this->db = $db;
        }

        public function insert(object $object):void {
            $r = new ReflectionClass(get_class($object));
            $docComment = AnnotationHandler::getDocComment($r);
            $tableName = AnnotationHandler::getAnnotation($docComment, Annotation::TABLE);

            if (is_null($tableName)) {
                //TODO melhorar isso aqui
                throw new Exception('OBJECT IS NOT A TABLE');
            }

            $idName = '';
            $parameters = [];
            do {
                foreach ($r->getProperties() as $prop) {
                    $doc = $prop->getDocComment();
                    if (AnnotationHandler::hasAnnotation($doc, Annotation::PRIMARY)) {
                        $idName = $prop->getName();
                        continue;
                    }
                    if (!AnnotationHandler::hasAnnotation($doc, Annotation::COLUMN)) {
                        continue;
                    }
                    $columnName = $prop->getName();
                    $parameters[$columnName] = $object->
                        {'get'.ucfirst($columnName)}();
                }
                $r = $r->getParentClass();
            }while($r);

            $insertId = $this->db->insert($tableName, $parameters);
            if ($idName !== '') {
                $object->{'set'.ucfirst($idName)}($insertId);
            }
        }

        protected function existsBy(string $propName, object $object, mixed $value):bool {
            $r = new ReflectionClass(get_class($object));
            $docComment = AnnotationHandler::getDocComment($r);
            $tableName = AnnotationHandler::getAnnotation($docComment, Annotation::TABLE);

            if (is_null($tableName)) {
                //TODO melhorar isso aqui
                throw new Exception('OBJECT IS NOT A TABLE');
            }

            return $this->db->existsBy($tableName, $propName, $value);
        }
    }