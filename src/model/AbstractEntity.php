<?php

    namespace Hairdresser\Model;
    use Hairdresser\Model\Database;

    abstract class AbstractEntity {
        protected int $id;
        protected string $tableName;
        private Database $database = new Database($this->getTableName());

        public function getTableName() {
            return $this->tableName;
        }

        public function setTableName($tableName) {
            $this->tableName = $tableName;
        }

        public function __construct(array $data, string $tableName) {
            $this->setTableName($tableName);
            $this->fromMap($data);
        }

        abstract function fromMap(array $data);
        abstract function toMap();

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function create() {
            $this->database->insert($this->toMap());
        }

        public function read($where = null, $orderBy = null, $limit = null) {
            $this->database->select(array_keys($this->toMap()), $where, $orderBy, $limit);
        }

        public function update() {
            $tableData = $this->toMap();
            unset($tableData["id"]);
            $this->database->update($this->getId(), $tableData);
        }

        public function delete() {
            $this->database->delete($this->getId());
        }
    }

?>