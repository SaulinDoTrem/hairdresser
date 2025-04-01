<?php

    namespace app\services;

    use ReflectionClass;

    abstract class Service {
        public function toDataObject(object $object):array {
            $r = new ReflectionClass(get_class($object));
            $dataObject = [];

            do {
                $classProperties = $r->getProperties();
                foreach ($classProperties as $p) {
                    $dataObject[$p->getName()] = $object->{'get'.ucfirst($p->getName())}();
                }
                $r = $r->getParentClass();
            }while($r);

            return $dataObject;
        }
    }