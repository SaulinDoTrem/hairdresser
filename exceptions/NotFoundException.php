<?php

    namespace app\exceptions;
    use app\enums\HttpStatus;

    class NotFoundException extends HttpException {
        protected HttpStatus $statusCode = HttpStatus::NOT_FOUND;
    }