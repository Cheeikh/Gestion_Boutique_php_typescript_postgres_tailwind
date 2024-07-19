<?php
// src/App/Entity/Entity.php
namespace App\Entity;

use ReflectionClass;

abstract class Entity {
    private $reflector;

    public function __construct() {
        $this->initReflector();
    }

    private function initReflector() {
        $this->reflector = new ReflectionClass($this);
    }

    public function __get($property) {
        return $this->getPropertyValue($property);
    }

    public function __set($property, $value) {
        $this->setPropertyValue($property, $value);
    }

    public function toArray() {
        if (!$this->reflector) {
            $this->initReflector();
        }
        $properties = $this->reflector->getProperties();
        $array = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($this);
        }

        return $array;
    }

    private function getPropertyValue($property) {
        if (!$this->reflector) {
            $this->initReflector();
        }
        if ($this->reflector->hasProperty($property)) {
            $prop = $this->reflector->getProperty($property);
            $prop->setAccessible(true);
            return $prop->getValue($this);
        }
        throw new \Exception("Property $property does not exist");
    }

    private function setPropertyValue($property, $value) {
        if (!$this->reflector) {
            $this->initReflector();
        }
        if ($this->reflector->hasProperty($property)) {
            $prop = $this->reflector->getProperty($property);
            $prop->setAccessible(true);
            $prop->setValue($this, $value);
        } else {
            throw new \Exception("Property $property does not exist");
        }
    }

    public function __isset($property) {
        if (!$this->reflector) {
            $this->initReflector();
        }
        return $this->reflector->hasProperty($property);
    }

    public function __serialize(): array
    {
        return $this->toArray();
    }

    public function __unserialize(array $data): void
    {
        $this->initReflector();
        $properties = $this->reflector->getProperties();
        foreach ($properties as $property) {
            $property->setAccessible(true);
            if (isset($data[$property->getName()])) {
                $property->setValue($this, $data[$property->getName()]);
            }
        }
    }
}