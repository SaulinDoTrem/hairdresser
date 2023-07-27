<?php
    namespace app\models;
    use app\models\AbstractModel;
    class Auth extends AbstractModel {
        protected string $tableName = "person";
        public function toMap():array {
            return [];
        }
        public function fromMap(array $body):void {

        }
    }
?>