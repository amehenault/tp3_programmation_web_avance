<?php

require_once __DIR__ . '/Route.php';

require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/PostController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/JournalController.php';

// Pages publiques (visiteurs)
Route::get('/', 'HomeController@index');
Route::get('/articles', 'PostController@index');
Route::get('/article', 'PostController@show');

// Connexion, déconnexion et inscription
Route::get('/login', 'AuthController@create');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');
Route::get('/inscription', 'UserController@create');
Route::post('/inscription', 'UserController@store');

// Pages des utilisateurs connectés (client ou admin)
Route::get('/profil', 'UserController@show');

// Pages réservées à l'administrateur
Route::get('/admin', 'AdminController@index');
Route::get('/admin/users', 'UserController@index');
Route::get('/journal', 'JournalController@index');
Route::get('/article/create', 'PostController@create');
Route::get('/article/edit', 'PostController@edit');
Route::post('/article/store', 'PostController@store');
Route::post('/article/update', 'PostController@update');
Route::post('/article/delete', 'PostController@destroy');
