<?php

    namespace Hairdresser\Model;

    class Person extends AbstractEntity {
        private string $name;
        private string $userName;
        private string $password;
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
        public function getPassword():string {
            return $this->password;
        }
        public function setPassword(string $password):void {
            $this->password = $password;
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "name"=> $this->getName(),
                "user_name"=> !empty($this->userName)
                    ? $this->getUserName()
                    : null,
                "password"=> !empty($this->password)
                    ? $this->getPassword()
                    : null
            ];
        }
        public function fromMap(array $data):void {
            $this->setId($data["id"]);
            $this->setName($data["name"]);
            if(!empty($data["user_name"]))
                $this->setUserName($data["user_name"]);
            if(!empty($data["password"]))
                $this->setPassword($data["password"]);
        }
    }
?>