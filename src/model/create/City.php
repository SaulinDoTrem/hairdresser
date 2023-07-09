<?php

    namespace Hairdresser\Model\Create;
    use Hairdresser\Model\AbstractEntity;

    class City extends AbstractEntity {
        private int $federative_unit_id;
        private string $name;

        public function getFederativeUnitId() {
            return $this->federative_unit_id;
        }

        public function setFederativeUnitId($federative_unit_id) {
            $this->federative_unit_id = $federative_unit_id;
        }

        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function toMap() {
            return [
                    "id"=> $this->getId(),
                    "ferative_unit_id"=> $this->getFederativeUnitId(),
                    "name" => $this->getName()
                ];
        }

        public function fromMap(array $data) {
            echo "a";
        }
    }
?>