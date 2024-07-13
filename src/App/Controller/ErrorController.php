<?php

namespace App\Controller;

use App\Authorize\Authorize;
use App\Files\FileHandler;
use App\Session\Session;

class ErrorController extends Controller {
    public function __construct(Authorize $authorize, FileHandler $fileHandler, Session $session) {
        parent::__construct($authorize, $fileHandler, $session, false);
    }

    public function notFound() {
        $this->render('Client/error');
    }

    public function forbidden() {
        $this->render('Client/forbidden');
    }
}