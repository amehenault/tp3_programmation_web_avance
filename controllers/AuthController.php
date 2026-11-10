<?php

require_once __DIR__ . '/../models/UserModel.php';

use App\Providers\View;
use App\Providers\Auth;

class AuthController {

    // Formulaire de connexion
    public function create(){
        // Déjà connecté : pas besoin de revoir le formulaire
        if (Auth::check()) {
            View::redirect('profil');
        }

        View::render('auth-login', [
            'pageTitle' => 'Connexion'
        ]);
    }

    // Traitement de la connexion
    public function store(){
        $username = trim($_POST['Username'] ?? '');
        $password = $_POST['Password'] ?? '';

        $errors = [];

        if ($username === '' || $password === '') {
            $errors[] = 'Le nom d’utilisateur et le mot de passe sont obligatoires.';
        }

        if (!$errors) {
            $userModel = new UserModel();
            $user = $userModel->checkLogin($username, $password);

            if ($user) {
                Auth::login($user);

                // L'administrateur arrive sur son tableau de bord
                if ($user['Role'] === 'admin') {
                    View::redirect('admin', 'Bienvenue ' . $user['Nom'] . ' !');
                }

                View::redirect('profil', 'Bienvenue ' . $user['Nom'] . ' !');
            }

            // Message volontairement général : on ne dit pas ce qui est faux
            $errors[] = 'Nom d’utilisateur ou mot de passe invalide.';
        }

        View::render('auth-login', [
            'pageTitle' => 'Connexion',
            'errors' => $errors,
            'username' => $username
        ]);
    }

    // Déconnexion
    public function delete(){
        Auth::logout();

        View::redirect('login', 'Vous êtes maintenant déconnecté.');
    }
}
