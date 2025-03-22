<?php

    namespace app\daos;
    use app\core\Database;
use Exception;
use ReflectionClass;

    // DAO abstrata para inserir dados no banco utilizando reflexão e anotações nos objetos modelos
    class Dao {
        private Database $db;
        public function __construct($db = new Database()) {
            $this->db = $db;
        }

        private function extractTableName($doc) {
            $matches = null;
            $match = preg_match('/@table\["([a-z_]+)"]/', $doc, $matches);
            if ($match) {
                return $matches[1];
            }
            return null;
        }

        public function insert($object): bool {
            // $query = 'INSERT INTO table_name(columns) VALUES(columns_value);';
            $r = new ReflectionClass(get_class($object));
            $tableName = $this->extractTableName($r->getDocComment());

            if (is_null($tableName)) {
                //TODO melhorar isso aqui
                throw new Exception('OBJECT IS NOT A TABLE');
            }

            $idName = 'id';
            $parameters = [];
            foreach ($r->getProperties() as $prop) {
                $doc = $prop->getDocComment();

                $propIsColumn = mb_strpos($doc, '@column') !== false;
                $propIsPrimaryColumn = mb_strpos($doc, '@primary') !== false;
                if ($propIsPrimaryColumn) {
                    $idName = $prop->getName();
                    continue;
                }
                if (!$propIsColumn) {
                    continue;
                }
                $columnName = $prop->getName();
                $columnMethodName = 'get'. ucfirst($columnName);
                $parameters[$columnName] = $object->{$columnMethodName}();
            }

            $insertId = $this->db->insert($tableName, $parameters);

            die(var_dump($insertId, $idName));
        }
    }