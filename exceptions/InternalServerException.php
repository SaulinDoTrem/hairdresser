<?php

    namespace app\exceptions;
    use app\enums\HttpStatus;

    class InternalServerException extends HttpException {
        protected HttpStatus $statusCode = HttpStatus::INTERNAL_SERVER_ERROR;
    }