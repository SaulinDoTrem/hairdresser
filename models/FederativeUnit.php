<?php

    namespace app\models;
    class FederativeUnit extends AbstractModel{
        protected string $tableName = "federative_unit";
        private string $name;
        private string $acronym;
        public function getName():string {
            return $this->name;
        }
        public function setName(string $name):void {
            $this->name = $name;
        }
        public function getAcronym():string {
            return $this->acronym;
        }
        public function setAcronym(string $acronym):void {
            $this->acronym = $acronym;
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "name"=> $this->getName(),
                "acronym"=> $this->getAcronym()
            ];
        }
        public function fromMap(array $data):void {
            $this->setId($data["id"]);
            $this->setName($data["name"]);
            $this->setAcronym($data["acronym"]);
        }
    }

?>