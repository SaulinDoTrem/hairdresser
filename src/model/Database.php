<?php

    namespace Hairdresser\Model;
    use PDOException;
    use PDO;

    class Database {
        private PDO $connection;
        private string $tableName;

        public function __construct(string $tableName) {
            $this->tableName = $tableName;
            $this->setConnection();
        }

        public function setConnection() {
            try {
                $configJson = json_decode(file_get_contents("../../config.json"), true);

                $host = $configJson["host"];
                $dbname = $configJson["dbname"];
                $user = $configJson["user"];
                $password = $configJson["password"];

                $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";
                $this->connection = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
            } catch(PDOException $e) {
                die("Erro ao conectar com o banco de dados. {$e->getMessage()}");
            }
        }

        public function getConnection() {
            return $this->connection;
        }

        public function execute(string $query, array $params=[], string $errorMessage) {
            try{
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params);
                return $stmt;
            }catch(PDOException $e) {
                die($errorMessage . " {$e->getMessage()}");
            }
        }

        public function insert(array $data) {
            if(empty($data))
                die("Informações não recebidas.");

            $fields = implode(", ", array_keys($data));
            $binds = implode(", ", array_pad([], count(array_keys($data)), "?"));

            $query = "INSERT INTO " . $this->tableName . "(" . $fields . ") VALUES (" . $binds .");";

            $this->execute($query, array_values($data), "Erro ao inserir na tabela {$this->tableName}.");

            return $this->connection->lastInsertId();
        }

        public function update(int $id, array $data) {
            if(empty($id) || empty($data))
                die("O Id ou os dados não foram recebidos com sucesso.");

            $columns = count($data) > 1 ? implode("=?, ", array_keys($data)) : array_keys($data)[0] . " = ?";

            $query = "UPDATE {$this->tableName} SET " . $columns .  " WHERE id = ?";

            $params = array_values($data);
            array_push($params, $id);

            return $this->execute($query, $params, "Erro ao atualizar id {$id} na tabela {$this->tableName}.")->rowCount();
        }

        public function delete(int $id) {
            if(empty($id))
                die("Id vazio ou nulo");

            $query = "DELETE FROM {$this->tableName} WHERE id = ?";

            return $this->execute($query, [$id], "Erro ao deletar id {$id} da tabela {$this->tableName}.")->rowCount();
        }

        public function select(array $columns, string $where = null, string $orderBy = null, string $limit = null) {

            //$where = "WHERE";


            //$query = "SELECT (o que selecionar) FROM {$this->tableName} WHERE (wheres) ORDER BY (order) LIMIT (limits)";
        }
    }

?>