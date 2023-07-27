<?php

    namespace app\models;
    use app\models\Task;
    use DateTime;
    class Schedule extends AbstractModel {
        protected string $tableName = "schedule";
        private Person $person; //customer/cliente/freguês
        private Task $task;
        private DateTime $date;
        public function getPerson():Person {
            return $this->person;
        }
        public function setPerson(Person $person):void {
            $this->person = $person;
        }
        public function getTask():Task {
            return $this->task;
        }
        public function setTask(Task $task):void {
            $this->task = $task;
        }
        public function setDate(DateTime $date):void {
            $this->date = $date;
        }
        public function getDate():DateTime {
            return $this->date;
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "person"=> $this->getPerson(),
                "task"=> $this->getTask(),
                "date"=> $this->getDate()
            ];
        }
        public function fromMap(array $data):void {
            $person = new Person();
            $task = new Task();

            $person->fromMap($data["person"]);
            $task->fromMap($data["task"]);

            $this->setId($data["id"]);
            $this->setPerson($person);
            $this->setTask($task);
            $this->setDate($data["date"]);
        }
    }
?>