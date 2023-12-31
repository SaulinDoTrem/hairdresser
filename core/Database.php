<?php
    namespace app\core;

    use app\core\Response;
    use app\models\AbstractModel;
    use app\core\Config;
    use app\models\Neighborhood;
    use PDOException;
    use PDO;
    use PDOStatement;
    use ReflectionClass;

    class Database {

        public function getConnection(): array {
            $connection = null;
            $message = null;
            $inputDotEnv = 'DB_';

            $host = $_ENV["{$inputDotEnv}HOST"];
            $dbname = $_ENV["{$inputDotEnv}NAME"];
            $user = $_ENV["{$inputDotEnv}USER"];
            $password = $_ENV["{$inputDotEnv}PASSWORD"];
            $host = "localhost";

            try {
                $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";
                $connection = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
            } catch(PDOException $e) {
                $message = "Erro ao conectar com o banco de dados. {$e->getMessage()}";
            }

            return ["connection"=> $connection, "message"=> $message];
        }

        public function execute(PDO $connection, string $query, string $errorMessage, array $params):PDOStatement|string {
            try{
                $stmt = $connection->prepare($query);
                $stmt->execute($params);
                return $stmt;
            }catch(PDOException $e) {
                die($errorMessage . $e->getMessage());
                //return $errorMessage . $e->getMessage();
            }
        }

        public function insert(PDO $connection, array $body) {
            // $tableData = $entity->toMap();
            // if(empty($tableData))
            //     Config::httpRequest("Os dados não foram recebidos com sucesso.", 400);

            // unset($tableData["id"]);

            // $fields = implode(", ", array_keys($tableData));
            // $binds = implode(", ", array_pad([], count(array_keys($tableData)), "?"));

            // $query = "INSERT INTO " . $this->tableName . "(" . $fields . ") VALUES (" . $binds .");";

            // $this->execute($query, "Erro ao inserir na tabela {$this->tableName}.", array_values($tableData));

            // return $this->connection->lastInsertId();
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

        public function select(PDO $connection, AbstractModel $model, int $id = null):array {
            $selectColumns = [];
            $joinTables = [];

            $this->buildSelectWithJoin($selectColumns, $joinTables, $model::class);

            $tableName = $model->getTableName();

            $where = "";
            $params = [];

            if($id !== null) {
                $params = ["id"=> $id];
                $where = " WHERE $tableName" . ".id = :id";
            }

            $select = "";

            foreach($selectColumns as $i => $selectColumn) {
                $select = "$select $selectColumn as " . str_replace(".", "__", $selectColumn);
                if($i !== array_key_last($selectColumns))
                    $select = "$select,";
            }

            $select = "SELECT $select FROM $tableName";
            $originalTableName = $tableName;

            $join = "";

            if(!empty($joinTables)) {
                foreach($joinTables as $joinTable) {
                    $join = "$join JOIN $joinTable ON ($joinTable" . ".id = $tableName" . ".id)";
                    $tableName = $joinTable;
                }
            }

            $joinTables = array_reverse($joinTables);
            array_push($joinTables, $originalTableName);

            $query = "$select$join$where;";

            $queryResults = $this->execute(
                $connection,
                $query,
                "Erro ao tentar fazer leitura da tabela $originalTableName.", $params
            )->fetchAll(PDO::FETCH_ASSOC);

            foreach($queryResults as $i => $queryResult) {
                $modelJson = [];
                foreach($joinTables as $joinTable) {
                    $tableJson = [];
                    foreach($queryResult as $column => $value) {
                        if(str_starts_with($column, $joinTable)) {
                            $columnName = explode("__", $column)[1];
                            $tableJson[$columnName] = $value;
                        }
                    }
                    $modelJson[$joinTable] = $tableJson;
                }
                $firstModelKey = array_key_first($modelJson);
                $previousModelKey = $firstModelKey;
                foreach($modelJson as $modelKey => $modelValue) {
                    if($modelKey !== $firstModelKey) {
                        $modelValue[$previousModelKey] = $modelJson[$previousModelKey];
                        $modelJson[$modelKey] = $modelValue;
                        unset($modelJson[$previousModelKey]);
                        $previousModelKey = $modelKey;
                    }
                }
                $model->fromMap($modelJson[$model->getTableName()]);
                $queryResults[$i] = $model->toMap();
            }

            if($id === null) return $queryResults;
            return $queryResults[0];
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

?>