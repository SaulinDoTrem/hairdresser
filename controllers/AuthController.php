<?php
    namespace app\controllers;
    use app\models\Auth;
    class AuthController{
        const PATH = "/login";
        public function post(array $data):array {
            $model = new Auth();
            $code = null;
            $message = null;
            return [
                "code"=> $code ?? 200,
                "message"=>$message ?? "",
                "data"=>$model->toMap()
            ];
        }
    }
?>