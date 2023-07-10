<?php

    namespace Hairdresser\Model;
    use Hairdresser\Model\AbstractEntity;

    class City extends AbstractEntity {
        protected string $tableName = "city";
        private FederativeUnit $federative_unit;
        private string $name;

        public function getFederativeUnit():FederativeUnit {
            return $this->federative_unit;
        }

        public function setFederativeUnit(array $federative_unitData):void {
            $federative_unit = new FederativeUnit();
            $federative_unit->fromMap($federative_unitData);
            $this->federative_unit = $federative_unit;
        }

        public function getName():string {
            return $this->name;
        }

        public function setName($name):void {
            $this->name = $name;
        }

        public function toMap():array {
            return [
                    "id"=> $this->getId(),
                    "federative_unit"=> $this->getFederativeUnit()->toMap(),
                    "name" => $this->getName()
                ];
        }

        public function fromMap(array $data):void {
            $this->setId($data["id"]);
            $this->setFederativeUnit($data["federative_unit"]);
            $this->setName($data["name"]);
        }
    }
?>