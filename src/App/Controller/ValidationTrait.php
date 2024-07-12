<?php
// src/App/Controller/ValidationTrait.php

namespace App\Controller;

trait ValidationTrait {
     function validate(array $data, array $rules): array {
        $errors = [];

        foreach ($rules as $field => $rule) {
            if (!isset($data[$field])) {
                $errors[$field] = 'Le champ est requis';
                continue;
            }

            if (!preg_match($rule['pattern'], $data[$field])) {
                $errors[$field] = $rule['message'];
            }
        }

        return $errors;
    }
}
