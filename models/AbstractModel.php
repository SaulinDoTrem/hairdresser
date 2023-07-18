<?php

    namespace app\models;

    abstract class AbstractModel {
        protected string $tableName;
        protected int $id;
        abstract function fromMap(array $data):void;
        abstract function toMap():array;
        abstract function getColumns():array;
        public function getTableName():string {
            return $this->tableName;
        }
        public function getId():int {
            return $this->id;
        }
        public function setId(int $id):void {
            $this->id = $id;
        }
    }

?>