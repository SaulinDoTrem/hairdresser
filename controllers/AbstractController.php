<?php

    namespace app\controllers;
    use app\models\AbstractModel;
    use app\core\Database;
    abstract class AbstractController {
        protected AbstractModel $model;
        public function setModel(AbstractModel $model):void {
            $this->model = $model;
        }
        public function get(array $requestData):array {

            $id = $requestData["id"] ?? null;

            $database = new Database();
            ["connection"=>$connection, "message"=>$message] = $database->getConnection();

            if(empty($message)) {
                $data = $database->select($connection, $this->model, $id);
                return [
                    "code"=> 200,
                    "message"=>"mensagem de sucesso",
                    "data"=>$data
                ];
            }

            return [
                "code"=> 500,
                "message"=> $message,
                "data"=> null
            ];
        }
        public function post(array $body):array {
            $code = null;
            $message = null;
            $data = null;
            $this->model->fromMap($body);
            return [
                "code"=> $code ?? 200,
                "message"=>$message ?? "",
                "data"=>$this->model->toMap()
            ];
        }
        public function put(array $data):array {
            $code = null;
            $message = null;
            $data = null;
            return [
                "code"=> $code ?? 200,
                "message"=>$message ?? "",
                "data"=>$data
            ];
        }
        public function delete(array $data):array {
            $code = null;
            $message = null;
            $data = null;
            return [
                "code"=> $code ?? 200,
                "message"=>$message ?? "",
                "data"=>$data
            ];
        }
    }

?>