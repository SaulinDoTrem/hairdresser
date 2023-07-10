<?php

    namespace Hairdresser\Model;

    class FederativeUnit extends AbstractEntity{
        private string $name;
        private string $acronym;

        public function getName():string {
            return $this->name;
        }

        public function setName($name):void {
            $this->name = $name;
        }

        public function getAcronym():string {
            return $this->acronym;
        }

        public function setAcronym($acronym):void {
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