<?php

    namespace app\controllers;

    abstract class AbstractController {
        protected string $path;
        public function getPath():string {
            return $this->path;
        }
        abstract function get(array $data):array;
        abstract function post(array $data):array;
        abstract function put(array $data):array;
        abstract function delete(array $data):array;
    }

?>