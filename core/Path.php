<?php

    namespace app\core;
    class Path {
        private string $path;

        public function __construct(
            string $path
        ) {
            if (!str_ends_with($path, '/')) {
                $path .= '/';
            }
            $this->path = $path;
        }

        public function getPath():string {
            return $this->path;
        }

        public function isSubPath(Path $subPath) {
            return str_starts_with($this->path, $subPath->getPath());
        }

        public function concat(string $path):Path {
            if (str_starts_with($path, '/')) {
                $path = substr($path, 1);
            }
            return new Path($this->path.$path);
        }
    }