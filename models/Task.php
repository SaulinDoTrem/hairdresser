<?php

    namespace app\models;
    class Task extends AbstractModel {
        protected string $tableName = "task";
        private Employee $employee;
        private string $estimatedMinutes;
        private string $description;
        private $price;
        public function getPrice() {
            return $this->price;
        }
        public function setPrice($price) {
            $this->price = $price;
        }
        public function getEmployee():Employee {
            return $this->employee;
        }
        public function setEmployee(Employee $employee):void {
            $this->employee = $employee;
        }
        public function getEstimatedMinutes():string {
            return $this->estimatedMinutes;
        }
        public function setEstimatedMinutes(string $estimatedMinutes):void {
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
                "description",
                "price"
            ];
        }
        public function toMap():array {
            return [
                "id"=> $this->getId(),
                "employee"=> $this->getEmployee()->toMap(),
                "estimated_minutes"=> $this->getEstimatedMinutes(),
                "description"=> $this->getDescription(),
                "price"=> $this->getPrice()
            ];
        }
        public function fromMap(array $data):void {
            $employee = new Employee();
            $employee->fromMap($data["employee"]);

            $this->setId($data["id"]);
            $this->setEmployee($employee);
            $this->setEstimatedMinutes($data["estimated_minutes"]);
            $this->setDescription($data["description"]);
            $this->setPrice($data["price"]);
        }
    }
?>