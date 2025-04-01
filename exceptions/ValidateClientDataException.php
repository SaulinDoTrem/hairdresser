<?php

    namespace app\exceptions;
    use app\enums\HttpStatus;

    class ValidateClientDataException extends HttpException {
        protected HttpStatus $statusCode = HttpStatus::BAD_REQUEST;
    }