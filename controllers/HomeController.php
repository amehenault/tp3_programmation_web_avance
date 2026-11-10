<?php

use App\Providers\View;

class HomeController {

    public function index(){
        View::render('home', [
            'pageTitle' => 'Accueil — Blogue coloré'
        ]);
    }
}