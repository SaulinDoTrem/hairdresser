<?php

    namespace Hairdresser\Model;
    use DateTime;

    class Employee extends AbstractEntity {
        private Person $person;
        private BeautySalon $beautySalon;
        private string $name;
        private DateTime $beginOfficeRoutine;
        private DateTime $endOfficeRoutine;
        public function getPerson():Person {
            return $this->person;
        }
        public function setPerson(Person $person) {
            $this->person = $person;
        }
        public function getName():string {
            return $this->name;
        }
        public function setName(string $name):void {
            $this->name = $name;
        }
        public function getBeautySalon():BeautySalon {
            return $this->beautySalon;
        }
        public function setBeautySalon(BeautySalon $beautySalon):void {
            $this->beautySalon = $beautySalon;
        }
        public function getBeginOfficeRoutine():DateTime {
            return $this->beginOfficeRoutine;
        }
        public function setBeginOfficeRoutine(DateTime $beginOfficeRoutine):void {
            $this->beginOfficeRoutine = $beginOfficeRoutine;
        }
        public function getEndOfficeRoutine():DateTime {
            return $this->endOfficeRoutine;
        }
        public function setEndOfficeRoutine(DateTime $endOfficeRoutine):void {
            $this->endOfficeRoutine = $endOfficeRoutine;
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "person"=> $this->getPerson()->toMap(),
                "beauty_salon"=> $this->getBeautySalon()->toMap(),
                "name"=> $this->getName(),
                "begin_office_routine"=> !empty($this->beginOfficeRoutine)
                    ? $this->getBeginOfficeRoutine()
                    : null,
                "end_office_routine"=> !empty($this->endOfficeRoutine)
                    ? $this->getEndOfficeRoutine()
                    : null
            ];
        }
        public function fromMap(array $data):void {
            $person = new Person();
            $beautySalon = new BeautySalon();

            $person->fromMap($data["person"]);
            $beautySalon->fromMap($data["beauty_salon"]);

            $this->setId($data["id"]);
            $this->setPerson($person);
            $this->setBeautySalon($beautySalon);
            $this->setName($data["name"]);
            if(!empty($data["begin_office_routine"]))
                $this->setBeginOfficeRoutine($data["begin_office_routine"]);
            if(!empty($data["end_office_routine"]))
                $this->setEndOfficeRoutine($data["end_office_routine"]);
        }
    }
?>