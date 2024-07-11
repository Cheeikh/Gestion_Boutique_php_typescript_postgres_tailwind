<?php
// src/App/validators/Validator.php

namespace App\validators;

class Validator {
private $errors = [];
private $rules = [];

public function validate() {
    foreach ($this->rules as $field => $rule) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            if (preg_match($rule['pattern'], $value) === 0) {
                $this->errors[$field] = $rule['message'];
            }
        }
    }
    return $this->errors;
}
}
