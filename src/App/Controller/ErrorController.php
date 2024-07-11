<?php

namespace App\Controller;

class ErrorController extends Controller {
    public function notFound() {
        $this->render('Client/error');
    }
    public function forbidden() {
        $this->render('Client/forbidden');
    }
}
