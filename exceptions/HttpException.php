<?php

    namespace app\exceptions;
    use Throwable;
    use Exception;
    use app\enums\HttpStatus;

    abstract class HttpException extends Exception {
        protected HttpStatus $statusCode;

        public function getStatusCode():HttpStatus {
            return $this->statusCode;
        }

        public function __construct(string $message = "", int $code = 0, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }