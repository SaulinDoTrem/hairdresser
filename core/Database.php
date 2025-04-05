<?php
    namespace app\core;

    use app\core\Config;
    use Generator;
    use PDOException;
    use PDO;
    use PDOStatement;
    use ReflectionClass;

    class Database {
        private PDO $connection;

        public function __construct(PDO $connection) {
            $this->connection = $connection;
        }

        public function execute(string $query, array $params = []):PDOStatement {
            try{
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params);
                return $stmt;
            }catch(PDOException $e) {
                throw $e;
            }
        }

        public function insert(string $tableName, array $parameters) {
            $fields = implode(", ", array_keys($parameters));
            $binds = implode(", ", array_pad([], count($parameters), "?"));
            $query = "INSERT INTO $tableName ($fields) VALUES ($binds);";
            $this->execute($query, array_values($parameters));
            return $this->connection->lastInsertId();
        }

        public function existsBy(string $tableName, string $columnName, mixed $value) {
            $query = "SELECT COUNT(*) > 0 as `exists` FROM $tableName WHERE $columnName = ?";
            $stmt = $this->execute($query, [$value]);
            return boolval($stmt->fetch()['exists']);
        }

        public function update(PDO $connection, array $body) {
            // $tableData = $entity->toMap();
            // $id = $entity->getId();
            // if(empty($id) || empty($tableData))
            //     Config::httpRequest("Alguns dados não foram recebidos com sucesso.", 400);

            // unset($tableData["id"]);

            // $columns = count($tableData) > 1 ? implode(" = ?, ", array_keys($tableData)) : array_keys($tableData)[0] . " = ?";

            // $query = "UPDATE {$this->tableName} SET " . $columns .  " WHERE id = ?";

            // $params = array_values($tableData);
            // array_push($params, $id);

            // return $this->execute($query, "Erro ao atualizar id {$id} na tabela {$this->tableName}.", $params)->rowCount();
        }

        public function delete(PDO $connection, array $arguments) {
            // if(empty($id))
            //     Config::httpRequest("Id vazio ou nulo.", 400);

            // $query = "DELETE FROM {$this->tableName} WHERE id = ?";

            // return $this->execute($query, "Erro ao deletar id {$id} da tabela {$this->tableName}.", [$id])->rowCount();
        }

        public function select(array $columns, string $tableName):Generator {
            $select = implode(', ', $columns);
            $query = "SELECT $select FROM $tableName";
            $stmt = $this->execute($query);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                yield $row;
            }
        }

        private function buildSelectWithJoin(array &$selectColumns, array &$joinTables, string $modelClassName) {
            $reflection = new ReflectionClass($modelClassName);
            $properties = $reflection->getProperties();
            $tableName = $reflection->getProperty("tableName")->getDefaultValue();
            $newTables = [];

            foreach($properties as $property) {
                $propertyName = $property->getName();
                $propertyType = $property->getType();

                if(str_starts_with($propertyType, "app")) {
                    array_push($joinTables, Config::formatAttributeNameToColumnName($propertyName));
                    array_push($newTables, $propertyType);
                }
                else if(!str_starts_with($propertyName, "tableName")) {
                    array_push($selectColumns, $tableName . "." . Config::formatAttributeNameToColumnName($propertyName));
                }
            }

            foreach($newTables as $newTable) {
                $this->buildSelectWithJoin($selectColumns, $joinTables, $newTable);
            }
        }
    }

