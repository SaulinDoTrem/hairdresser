<?php

    namespace app\exceptions;
    use app\enums\HttpStatus;

    class MethodNotAllowedException extends HttpException {
        protected HttpStatus $statusCode = HttpStatus::METHOD_NOT_ALLOWED;
    }