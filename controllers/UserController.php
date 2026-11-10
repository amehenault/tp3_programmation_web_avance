<?php

require_once __DIR__ . '/../models/UserModel.php';

use App\Providers\View;
use App\Providers\Auth;

class UserController {

    // Liste des utilisateurs (admin seulement)
    public function index(){
        Auth::admin();

        $userModel = new UserModel();
        $users = $userModel->getAll();

        View::render('user-index', [
            'pageTitle' => 'Utilisateurs',
            'users' => $users
        ]);
    }

    // Page "Mon profil" (client ou admin connecté)
    public function show(){
        Auth::session();

        $userModel = new UserModel();
        $user = $userModel->getById($_SESSION['userId']);

        if (!$user) {
            Auth::logout();
            View::redirect('login', 'Votre compte est introuvable.');
        }

        View::render('user-show', [
            'pageTitle' => 'Mon profil',
            'user' => $user
        ]);
    }

    // Formulaire d'inscription (ou d'ajout d'utilisateur pour l'admin)
    public function create(){
        // Un client déjà connecté n'a pas besoin de créer un compte
        if (Auth::check() && !Auth::isAdmin()) {
            View::redirect('profil');
        }

        View::render('user-create', [
            'pageTitle' => 'Créer un compte'
        ]);
    }

    public function store(){
        if (Auth::check() && !Auth::isAdmin()) {
            View::redirect('profil');
        }

        $nom = trim($_POST['Nom'] ?? '');
        $email = trim($_POST['Email'] ?? '');
        $username = trim($_POST['Username'] ?? '');
        $password = $_POST['Password'] ?? '';
        $confirmation = $_POST['Confirmation'] ?? '';

        // Seul l'admin peut choisir le rôle, sinon c'est toujours un client
        $role = 'client';

        if (Auth::isAdmin() && ($_POST['Role'] ?? '') === 'admin') {
            $role = 'admin';
        }

        $userModel = new UserModel();

        $errors = [];

        if ($nom === '') {
            $errors[] = 'Le nom est obligatoire.';
        } elseif (mb_strlen($nom) > 100) {
            $errors[] = 'Le nom doit contenir au maximum 100 caractères.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Le courriel est invalide.';
        } elseif ($userModel->getByEmail($email)) {
            $errors[] = 'Ce courriel est déjà utilisé.';
        }

        if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
            $errors[] = 'Le nom d’utilisateur doit contenir de 3 à 50 lettres, chiffres ou _.';
        } elseif ($userModel->getByUsername($username)) {
            $errors[] = 'Ce nom d’utilisateur est déjà utilisé.';
        }

        if (mb_strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        } elseif ($password !== $confirmation) {
            $errors[] = 'Les deux mots de passe ne correspondent pas.';
        }

        if (!$errors) {
            try {
                $userModel->createUser([
                    'Nom' => $nom,
                    'Email' => $email,
                    'Username' => $username,
                    'Password' => $password,
                    'Role' => $role
                ]);

                if (Auth::isAdmin()) {
                    View::redirect('admin/users', 'L’utilisateur a été ajouté avec succès.');
                }

                View::redirect('login', 'Votre compte a été créé. Vous pouvez vous connecter.');
            } catch (PDOException $e) {
                $errors[] = 'Impossible de créer le compte pour le moment.';
            }
        }

        View::render('user-create', [
            'pageTitle' => 'Créer un compte',
            'errors' => $errors,
            'nom' => $nom,
            'email' => $email,
            'username' => $username,
            'role' => $role
        ]);
    }
}
