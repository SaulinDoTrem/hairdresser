<?php

    namespace app\controllers;

    use app\enums\HttpStatus;
    use app\models\ControllerResponse;

    class Controller {
        protected function Ok(array $data) {
            return new ControllerResponse(
                HttpStatus::OK,
                $data
            );
        }
        protected function Created(array $data) {
            return new ControllerResponse(
                HttpStatus::CREATED,
                $data
            );
        }
    }