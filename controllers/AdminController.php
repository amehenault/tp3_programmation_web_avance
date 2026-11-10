<?php

require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/JournalModel.php';

use App\Providers\View;
use App\Providers\Auth;

class AdminController {

    // Tableau de bord de l'administrateur
    public function index(){
        Auth::admin();

        $postModel = new PostModel();
        $userModel = new UserModel();
        $journalModel = new JournalModel();

        View::render('admin-index', [
            'pageTitle' => 'Administration',
            'posts' => $postModel->getAll(),
            'nbPosts' => $postModel->countAll(),
            'nbUsers' => $userModel->countAll(),
            'nbVisites' => $journalModel->countAll()
        ]);
    }
}
