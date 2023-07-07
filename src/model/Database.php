<?php

    namespace hairdresser\model;
    use PDOException;
    use PDO;

    $piru = new Database("cidade");

    $int = $piru->insert(["uf_id"=>1,"nome"=>"Alameda do Seu zé212123211231222323"]);

    var_dump($int);

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

        public function execute(string $query, array $params=[]) {
            try{
                $stmt = $this->connection->prepare($query);
                $stmt->execute($params);
                return $stmt;
            }catch(PDOException $e) {
                die("Erro ao tentar inserir na tabela {$this->tableName}. {$e->getMessage()}");
            }
        }

        public function insert(array $data) {
            if(empty($data))
                die("Informações não recebidas.");

            $fields = implode(", ", array_keys($data));
            $binds = implode(", ", array_pad([], count(array_keys($data)), "?"));

            $query = "INSERT INTO " . $this->tableName . "(" . $fields . ") VALUES (" . $binds .");";

            var_dump($query);

            $this->execute($query, array_values($data));

            return $this->connection->lastInsertId();
        }

        public function update() {

        }

        public function delete() {

        }

        public function select() {

        }
    }

?>