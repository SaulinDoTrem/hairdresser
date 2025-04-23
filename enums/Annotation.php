<?php

    namespace app\enums;

    enum Annotation:string {
        case ROUTE = '@Route';
        case PATH = '@Path';
        case METHOD = '@Method';
        case TABLE = '@Table';
        case COLUMN = '@Column';
        case PRIMARY = '@Primary';
        case ONE_TO_MANY = '@OneToMany';

        public function getRegexPattern():string {
            return match($this) {
                Annotation::ROUTE => '\/([a-z\d]+\/)+[a-z\d]+\/{0,1}',
                Annotation::PATH => '\/(([a-z\d]+\/)+[a-z\d]+\/{0,1}){0,1}',
                Annotation::METHOD => '[A-Z]+',
                Annotation::TABLE, Annotation::ONE_TO_MANY => '[a-z_]+',
                Annotation::COLUMN => '[a-z_]*',
                default => false
            };
        }

        public function matches(string $docComment, string|null &$annotationValue):bool {
            $matches = [];
            $pattern = $this->getRegexPattern();
            if ($pattern === false) {
                return false;
            }

            if (
                preg_match(
                    "/{$this->value}\[\"($pattern)\"\]/",
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