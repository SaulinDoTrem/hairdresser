<?php

    namespace Hairdresser\Model;

    class City extends AbstractEntity {
        protected string $tableName = "city";
        private FederativeUnit $federativeUnit;
        private string $name;
        public function getFederativeUnit():FederativeUnit {
            return $this->federativeUnit;
        }
        public function setFederativeUnit(FederativeUnit $federativeUnit):void {
            $this->federativeUnit = $federativeUnit;
        }
        public function getName():string {
            return $this->name;
        }
        public function setName(string $name):void {
            $this->name = $name;
        }
        public function getColumns():array {
            return [
                "id",
                "federative_unit_id",
                "name"
            ];
        }
        public function toMap():array {
            return [
                    "id"=> $this->getId(),
                    "federative_unit"=> $this->getFederativeUnit()->toMap(),
                    "name" => $this->getName()
                ];
        }
        public function fromMap(array $data):void {
            $federativeUnit = new FederativeUnit();
            $federativeUnit->fromMap($data["federative_unit"]);

            $this->setId($data["id"]);
            $this->setFederativeUnit($federativeUnit);
            $this->setName($data["name"]);
        }
    }
?>