<?php

    namespace app\core;

    class Route {
        private string $classNamespace;
        private string $methodName;

        public function __construct(
            string $classNamespace,
            string $methodName
        ) {
            $this->classNamespace = $classNamespace;
            $this->methodName = $methodName;
        }

        public function getClassNamespace():string {
            return $this->classNamespace;
        }

        public function getMethodName():string {
            return $this->methodName;
        }
    }