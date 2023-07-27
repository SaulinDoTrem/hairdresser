<?php

    namespace app\models;
    class Person extends AbstractModel {
        protected string $tableName = "person";
        private string $name;
        private string $userName;
        public function getName():string {
            return $this->name;
        }
        public function setName(string $name):void {
            $this->name = $name;
        }
        public function getUserName():string {
            return $this->userName;
        }
        public function setUserName(string $userName):void {
            $this->userName = $userName;
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "name"=> $this->getName(),
                "user_name"=> !empty($this->userName)
                    ? $this->getUserName()
                    : null
            ];
        }
        public function fromMap(array $data):void {
            $this->setId($data["id"]);
            $this->setName($data["name"]);
            if(!empty($data["user_name"]))
                $this->setUserName($data["user_name"]);
        }
    }
?>