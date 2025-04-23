<?php

    namespace app\daos;
    use app\core\Database;
    use app\enums\Annotation;
    use app\utils\AnnotationHandler;
    use DateTime;
    use Exception;
    use Generator;
    use ReflectionClass;
    use ReflectionProperty;

    // DAO abstrata para inserir dados no banco utilizando reflexão e anotações nos objetos modelos
    abstract class Dao {
        private Database $db;
        public function __construct(Database $db) {
            $this->db = $db;
        }

        public function insert(object $object):void {
            $r = new ReflectionClass(get_class($object));
            $docComment = AnnotationHandler::getDocComment($r);
            $tableName = AnnotationHandler::getAnnotation($docComment, Annotation::TABLE);

            if ($tableName == false) {
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

                    $columnName = AnnotationHandler::getColumnName($prop, $doc);;
                    $parameters[$columnName] = $this->getColumnValue($object, $doc, $prop);
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

            if ($tableName == false) {
                //TODO melhorar isso aqui
                throw new Exception('OBJECT IS NOT A TABLE');
            }

            return $this->db->existsBy($tableName, $propName, $value);
        }

        public function getAll($class):Generator {
            $r = new ReflectionClass($class);
            $tableName = $this->getTableName($r);
            $columns = $this->getColumns($r);
            $result = $this->db->select($columns, $tableName);
            foreach ($result as $props) {
                yield $this->newInstanceOfClass($r, $props);
            }
        }

        private function getTableName(ReflectionClass $r):string {
            $docComment = AnnotationHandler::getDocComment($r);
            $tableName = AnnotationHandler::getAnnotation($docComment, Annotation::TABLE);
            if ($tableName == false) {
                //TODO melhorar isso aqui
                throw new Exception('OBJECT IS NOT A TABLE');
            }
            return $tableName;
        }

        private function getColumns(ReflectionClass $r):array {
            $columns = [];
            do {
                foreach ($r->getProperties() as $prop) {
                    $doc = $prop->getDocComment();
                    if (AnnotationHandler::hasAnnotation($doc, Annotation::COLUMN)) {
                        $columns[] = AnnotationHandler::getColumnName($prop, $doc);
                    }
                }
                $r = $r->getParentClass();
            }while($r);
            return $columns;
        }

        protected function getByColumn($columnName, $columnValue, $objectClass) {
            $r = new ReflectionClass($objectClass);
            $tableName = $this->getTableName($r);
            $columns = $this->getColumns($r);
            $parameters = [$columnName => $columnValue];
            $objectArgs = $this->db->select($columns, $tableName, $parameters);
            return $this->newInstanceOfClass($r, $objectArgs->current());
        }

        private function newInstanceOfClass(ReflectionClass $reflection, array|null $columns):object|null {
            if (empty($columns)) {
                return null;
            }
            // TODO - pensar quando a coluna for um objeto como user_id -> User para a Autenticação
            $object = $reflection->newInstance();
            foreach ($columns as $column => $value) {
                $object->{'set'.ucfirst($column)}($value);
            }
            return $object;
        }

        private function getColumnValue(object $object, string $doc, ReflectionProperty $prop) {
            $annotation = Annotation::ONE_TO_MANY;
            $propValue = $object->{'get'.ucfirst($prop->getName())}();
            if (AnnotationHandler::hasAnnotation($doc, $annotation)) {
                $columnName = AnnotationHandler::getAnnotation($doc, $annotation);
                $propValue = $propValue->{'get'.ucfirst($columnName)}();
            }

            return $propValue;
        }
    }