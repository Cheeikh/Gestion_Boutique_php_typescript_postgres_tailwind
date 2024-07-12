<?php
// src/App/Validator/ValidatorInterface.php

namespace App\Validator;

interface ValidatorInterface {
    public function validate(array $data, array $rules): array;
}