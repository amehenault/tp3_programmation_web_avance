<?php
require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once 'routes/web.php';

use App\Providers\Auth;

// Démarre la session sécurisée avant de traiter la page
Auth::start();

Route::dispatch();


