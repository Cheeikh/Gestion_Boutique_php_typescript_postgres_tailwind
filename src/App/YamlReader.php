<?php

namespace App;

class YamlReader {
    public static function parse(string $file): array {
        $contents = file_get_contents($file);
        return self::parseYaml($contents);
    }

    private static function parseYaml(string $yaml): array {
        $lines = explode("\n", $yaml);
        $data = [];
        $path = [];

        foreach ($lines as $line) {
            if (preg_match('/^\s*$/', $line)) {
                continue;
            }
            $indent = strspn($line, ' ');
            $keyValue = trim(substr($line, $indent));
            list($key, $value) = array_pad(explode(':', $keyValue, 2), 2, null);
            $key = trim($key);
            $value = trim($value);
            if (substr($value, 0, 1) === '"' && substr($value, -1, 1) === '"') {
                $value = substr($value, 1, -1);
            }
            while ($indent < count($path)) {
                array_pop($path);
            }
            $ref = &$data;
            foreach ($path as $step) {
                $ref = &$ref[$step];
            }
            if ($value === '') {
                $ref[$key] = [];
                $path[] = $key;
            } else {
                $ref[$key] = $value;
            }
        }
        return $data;
    }
}
