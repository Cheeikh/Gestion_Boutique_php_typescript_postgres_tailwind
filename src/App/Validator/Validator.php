<?php
// src/App/Validator/Validator.php

namespace App\Validator;

class Validator implements ValidatorInterface {
    private $errors = [];
    private $rules = [];

    public function validate(array $data, array $rules): array {
        foreach ($rules as $field => $rule) {
            if (isset($data[$field])) {
                $value = $data[$field];
                if (preg_match($rule['pattern'], $value) === 0) {
                    $this->errors[$field] = $rule['message'];
                }
            } else {
                $this->errors[$field] = 'Le champ est requis';
            }
        }
        return $this->errors;
    }
}
