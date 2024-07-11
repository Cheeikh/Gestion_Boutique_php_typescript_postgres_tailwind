<?php
// Dans src/App/Exceptions/RouteNotFoundException.php
namespace App\Exceptions;

class RouteNotFoundException extends \Exception
{
    protected $message = 'No route matched.';
}