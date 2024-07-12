<?php

namespace App;

use ReflectionClass;

class Container {
    private $instances = [];
    private $config = [];

    public function __construct(string $configFile) {
        $this->config = YamlReader::parse($configFile);
    }

    public function get($class) {
        if (!isset($this->instances[$class])) {
            $this->instances[$class] = $this->createInstance($class);
        }
        return $this->instances[$class];
    }

    private function createInstance($class) {
        if (!isset($this->config[$class])) {
            throw new \Exception("Class $class not found in container configuration.");
        }

        $dependencies = [];
        if (isset($this->config[$class]['arguments'])) {
            foreach ($this->config[$class]['arguments'] as $dependency) {
                $dependencies[] = $this->get($dependency);
            }
        }

        $reflector = new ReflectionClass($class);
        return $reflector->newInstanceArgs($dependencies);
    }
}
