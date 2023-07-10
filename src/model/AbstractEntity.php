<?php

    namespace Hairdresser\Model;

    abstract class AbstractEntity {
        protected string $tableName;
        protected int $id;

        abstract function fromMap(array $data):void;
        abstract function toMap():array;

        public function getTableName():string {
            return $this->tableName;
        }

        public function getId():int {
            return $this->id;
        }

        public function setId($id):void {
            $this->id = $id;
        }
    }

?>