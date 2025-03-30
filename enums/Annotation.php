<?php

    namespace app\enums;

    enum Annotation:string {
        case ROUTE = 'route';
        case PATH = 'path';
        case METHOD = 'method';

        public function getRegexPattern():string {
            return match($this) {
                Annotation::ROUTE => '\/([a-z\d]+\/)+[a-z\d]+\/{0,1}',
                Annotation::PATH => '\/(([a-z\d]+\/)+[a-z\d]+\/{0,1}){0,1}',
                Annotation::METHOD => '[A-Z]+'
            };
        }

        public function matches(string $docComment, string|null &$annotationValue):bool {
            $matches = [];
            $pattern = $this->getRegexPattern();
            if (
                preg_match(
                    "/@{$this->value}\[\"($pattern)\"\]/",
                    $docComment,
                    $matches
                )
            ) {
                $annotationValue = $matches[1];
                return true;
            }
            return false;
        }
    }