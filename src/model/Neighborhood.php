<?php

    namespace Hairdresser\Model;

    class Neighborhood extends AbstractEntity{
        protected string $tableName = "neighborhood";
        private City $city;
        private string $name;
        public function getCity():City {
            return $this->city;
        }
        public function setCity(City $city):void {
            $this->city = $city;
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
                "city_id",
                "name"
            ];
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "city"=> $this->getCity()->toMap(),
                "name"=> $this->getName()
            ];
        }
        public function fromMap(array $data):void {
            $city = new City();
            $city->fromMap($data["city"]);

            $this->setId($data["id"]);
            $this->setCity($city);
            $this->setName($data["name"]);
        }
    }
?>