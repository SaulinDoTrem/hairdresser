<?php
    namespace Hairdresser\Controller;
    use Dotenv\Dotenv;
use Hairdresser\Model\AbstractEntity;
use PDOException;
    use PDO;
    use PDOStatement;

    class Database {
        private PDO $connection;
        private string $tableName;

        public function __construct(string $tableName) {
            $this->tableName = $tableName;
            $this->setConnection();
        }

        public function setConnection():void {
            try {
                $dotenv = Dotenv::createImmutable(__DIR__."/../..");
                $dotenv->load();

                $inputDotEnv = 'DATABASE_';

                $host = $_ENV["{$inputDotEnv}HOST"];
                $dbname = $_ENV["{$inputDotEnv}NAME"];
                $user = $_ENV["{$inputDotEnv}USER"];
                $password = $_ENV["{$inputDotEnv}PASSWORD"];

                $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";
                $this->connection = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
            } catch(PDOException $e) {
                die("Erro ao conectar com o banco de dados. {$e->getMessage()}");
            }
        }

        public function getConnection():PDO {
            return $this->connection;
        }

        public function execute(string $query, string $errorMessage, array $params):PDOStatement {
            try{
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params);
                return $stmt;
            }catch(PDOException $e) {
                die($errorMessage . " {$e->getMessage()}");
            }
        }

        public function insert(AbstractEntity $entity):int {
            $tableData = $entity->toMap();
            if(empty($tableData))
                die("Dados não foram recebidos com sucesso.");

            unset($tableData["id"]);

            $fields = implode(", ", array_keys($tableData));
            $binds = implode(", ", array_pad([], count(array_keys($tableData)), "?"));

            $query = "INSERT INTO " . $this->tableName . "(" . $fields . ") VALUES (" . $binds .");";

            $this->execute($query, "Erro ao inserir na tabela {$this->tableName}.", array_values($tableData));

            return $this->connection->lastInsertId();
        }

        public function update(AbstractEntity $entity):int {
            $tableData = $entity->toMap();
            $id = $entity->getId();
            if(empty($id) || empty($tableData))
                die("O Id ou os dados não foram recebidos com sucesso.");

            unset($tableData["id"]);

            $columns = count($tableData) > 1 ? implode(" = ?, ", array_keys($tableData)) : array_keys($tableData)[0] . " = ?";

            $query = "UPDATE {$this->tableName} SET " . $columns .  " WHERE id = ?";

            $params = array_values($tableData);
            array_push($params, $id);

            return $this->execute($query, "Erro ao atualizar id {$id} na tabela {$this->tableName}.", $params)->rowCount();
        }

        public function delete(int $id):int {
            if(empty($id))
                die("Id vazio ou nulo.");

            $query = "DELETE FROM {$this->tableName} WHERE id = ?";

            return $this->execute($query, "Erro ao deletar id {$id} da tabela {$this->tableName}.", [$id])->rowCount();
        }

        public function select(array $columnNames, string $where = null, array $params=[], string $orderBy = null, string $limit = null):array {
            if(empty($columnNames))
                die("Dados não foram recebidos com sucesso.");

            $select = implode(", ", $columnNames);
            function buildQueryText($text, $prefix) {
                return !empty($text) ? $prefix . " " . $text . " " : "";
            };

            $where = buildQueryText($where,"WHERE");
            $orderBy = buildQueryText($orderBy,"ORDER BY");
            $limit = buildQueryText($limit,"LIMIT");

            $query = "SELECT " . $select . " FROM {$this->tableName} " . $where . $orderBy . $limit .";";


            return $this->execute($query, "Erro ao tentar fazer leitura da tabela {$this->tableName}.", $params)->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>