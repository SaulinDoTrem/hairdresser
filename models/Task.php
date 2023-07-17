<?php

    namespace Hairdresser\Model;

    class Task extends AbstractEntity {
        protected string $tableName = "task";
        private Employee $employee;
        private int $estimatedMinutes;
        private string $description;
        public function getEmployee():Employee {
            return $this->employee;
        }
        public function setEmployee(Employee $employee):void {
            $this->employee = $employee;
        }
        public function getEstimatedMinutes():int {
            return $this->estimatedMinutes;
        }
        public function setEstimatedMinutes(int $estimatedMinutes):void {
            $this->estimatedMinutes = $estimatedMinutes;
        }
        public function getDescription():string {
            return $this->description;
        }
        public function setDescription(string $description):void {
            $this->description = $description;
        }
        public function getColumns():array {
            return [
                "id",
                "employee_id",
                "estimated_minutes",
                "description"
            ];
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "employee"=> $this->getEmployee()->toMap(),
                "estimated_minutes"=> $this->getEstimatedMinutes(),
                "description"=> $this->getDescription()
            ];
        }
        public function fromMap(array $data):void {
            $employee = new Employee();
            $employee->fromMap($data["employee"]);

            $this->setId($data["id"]);
            $this->setEmployee($employee);
            $this->setEstimatedMinutes($data["estimated_minutes"]);
            $this->setDescription($data["description"]);
        }
    }
?>