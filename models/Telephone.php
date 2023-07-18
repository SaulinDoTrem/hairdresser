<?php

    namespace app\models;
    class Telephone extends AbstractModel {
        protected string $tableName = "telephone";
        private Person $person;
        private int $areaNumber;
        private int $number;
        public function getPerson():Person {
            return $this->person;
        }
        public function setPerson(Person $person):void {
            $this->person = $person;
        }
        public function getAreaNumber():int {
            return $this->areaNumber;
        }
        public function setAreaNumber(int $areaNumber):void {
            $this->areaNumber = $areaNumber;
        }
        public function getNumber():int {
            return $this->number;
        }
        public function setNumber(int $number):void {
            $this->number = $number;
        }
        public function getColumns():array {
            return [
                "id",
                "person_id",
                "area_number",
                "number"
            ];
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "person"=> $this->getPerson()->toMap(),
                "area_number"=> $this->getAreaNumber(),
                "number"=> $this->getNumber()
            ];
        }
        public function fromMap(array $data):void {
            $person = new Person();
            $person->fromMap($data["person"]);

            $this->setId($data["id"]);
            $this->setPerson($person);
            $this->setAreaNumber($data["area_number"]);
            $this->setNumber($data["number"]);
        }
    }
?>