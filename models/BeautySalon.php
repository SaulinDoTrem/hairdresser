<?php

    namespace app\models;
    use app\models\Neighborhood;

    class BeautySalon extends AbstractModel {
        protected string $tableName = "beauty_salon";
        private Neighborhood $neighborhood;
        private string $name;
        private string $publicPlace;
        private int $number;
        public function getNeighborhood():Neighborhood {
            return $this->neighborhood;
        }
        public function setNeighborhood(Neighborhood $neighborhood):void {
            $this->neighborhood = $neighborhood;
        }
        public function getName():string {
            return $this->name;
        }
        public function setName(string $name):void {
            $this->name = $name;
        }
        public function getPublicPlace():string {
            return $this->publicPlace;
        }
        public function setPublicPlace(string $publicPlace):void {
            $this->publicPlace = $publicPlace;
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
                "neighborhood_id",
                "name",
                "public_place",
                "number"
            ];
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "neighborhood"=> $this->getNeighborhood()->toMap(),
                "name"=> $this->getName(),
                "public_place"=> !empty($this->publicPlace)
                    ? $this->getPublicPlace()
                    : null,
                "number"=> !empty($this->number)
                    ? $this->getNumber()
                    : null
            ];
        }
        public function fromMap(array $data):void {
            $neighborhood = new Neighborhood();
            $neighborhood->fromMap($data["neighborhood"]);

            $this->setId($data["id"]);
            $this->setNeighborhood($neighborhood);
            $this->setName($data["name"]);
            if(!empty($data["public_place"]))
                $this->setPublicPlace($data["public_place"]);
            if(!empty($data["number"]))
                $this->setNumber($data["number"]);
        }
    }
?>