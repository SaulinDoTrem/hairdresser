<?php
    namespace app\controllers;
    use app\core\Request;

    class testaController extends AbstractController{
        protected string $path = "/testa";
        public function getPath():string {
            return $this->path;
        }
        public function get(array $data):array {
            $code = null;
            $message = null;
            $data = null;
            return [
                "code"=> $code ?? 200,
                "message"=>$message ?? "",
                "data"=>$data
            ];
        }
        public function post(array $data):array {
            $code = null;
            $message = null;
            $data = null;
            return [
                "code"=> $code ?? 200,
                "message"=>$message ?? "",
                "data"=>$data
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