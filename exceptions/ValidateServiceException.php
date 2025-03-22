<?php

    namespace app\exceptions;
    use app\enums\HttpStatus;

    class ValidateServiceException extends HttpException {
        protected HttpStatus $statusCode = HttpStatus::BAD_REQUEST;
    }