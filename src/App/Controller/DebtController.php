<?php
// src/App/Controller/DebtController.php

namespace App\Controller;

use App\Model\DebtModel;
use App\Controller\Api\Api;
use App\Entity\ApiEntity;

class DebtController extends Controller {
    
    public function show() {
        $debtModel = new DebtModel($this->app->getDatabase());
        $dettes = $debtModel->show();

        if ($this->isApi) {
            $apiEntity = new ApiEntity();
            
            // Convertir chaque DebtEntity en tableau
            $dettesArray = array_map(function($debtEntity) {
                return $debtEntity->toArray();
            }, $dettes);

            $apiEntity->data = $dettesArray; // Utilisation de __set

            $api = new Api();
            $api->renderJson($apiEntity->data); // Utilisation de __get
        } else {
            $this->render('Client/clients', ['dettes' => $dettes]);
        }
    }
}