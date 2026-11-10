<?php

require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CategorieModel.php';

use App\Providers\View;
use App\Providers\Auth;
use App\Providers\Upload;

class PostController {

    // Page publique
    public function index(){
        $postModel = new PostModel();

        $posts = $postModel->getAll();

        View::render('post-index', [
            'pageTitle' => 'Articles',
            'posts' => $posts
        ]);
    }

    // Page publique
    public function show(){
        $id = (int) ($_GET['id'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);

            View::render('error', [
                'pageTitle' => 'Article introuvable',
                'message' => 'Cet article n’existe pas.'
            ]);

            return;
        }

        View::render('post-show', [
            'pageTitle' => $post['Titre'],
            'post' => $post
        ]);
    }

    // Admin seulement
    public function create(){
        Auth::admin();

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        // Seuls les administrateurs peuvent être auteurs
        $users = $userModel->getAdmins();
        $categories = $categorieModel->getAll();

        View::render('post-create', [
            'pageTitle' => 'Ajouter un article',
            'users' => $users,
            'categories' => $categories
        ]);
    }

    // Admin seulement
    public function store(){
        Auth::admin();

        $titre = trim($_POST['Titre'] ?? '');
        $contenu = trim($_POST['Contenu'] ?? '');
        $idUser = (int) ($_POST['Users_idUsers'] ?? 0);

        $categoryIds = $_POST['categories'] ?? [];

        // Image téléversée (facultative)
        $image = $_FILES['Image'] ?? null;

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAdmins();
        $categories = $categorieModel->getAll();

        $errors = [];

        if ($titre === '') {
            $errors[] = 'Le titre est obligatoire.';
        } elseif (mb_strlen($titre) > 255) {
            $errors[] = 'Le titre doit contenir au maximum 255 caractères.';
        }

        if ($contenu === '') {
            $errors[] = 'Le contenu est obligatoire.';
        }

        $userIds = array_map(
            'intval',
            array_column($users, 'idUsers')
        );

        if (!in_array($idUser, $userIds, true)) {
            $errors[] = 'Choisis un auteur valide.';
        }

        if (!is_array($categoryIds)) {
            $errors[] = 'Les catégories sont invalides.';
            $categoryIds = [];
        }

        $categoryIds = array_unique(
            array_map('intval', $categoryIds)
        );

        $validCategoryIds = array_map(
            'intval',
            array_column($categories, 'idCategories')
        );

        if (array_diff($categoryIds, $validCategoryIds)) {
            $errors[] = 'Une catégorie sélectionnée est invalide.';
        }

        $imageError = Upload::validateImage($image);

        if ($imageError) {
            $errors[] = $imageError;
        }

        if (!$errors) {
            try {
                $imageName = Upload::saveImage($image);

                $postModel = new PostModel();

                $idPost = $postModel->createPost([
                    'Titre' => $titre,
                    'Contenu' => $contenu,
                    'Image' => $imageName,
                    'Create_at' => date('Y-m-d H:i:s'),
                    'Users_idUsers' => $idUser
                ], $categoryIds);

                View::redirect(
                    'article?id=' . $idPost,
                    'L’article a été ajouté avec succès.'
                );
            } catch (PDOException $e) {
                $errors[] = 'Impossible d’enregistrer l’article pour le moment.';
            } catch (RuntimeException $e) {
                $errors[] = 'Impossible d’enregistrer l’article pour le moment.';
            }
        }

        View::render('post-create', [
            'pageTitle' => 'Ajouter un article',
            'users' => $users,
            'categories' => $categories,
            'errors' => $errors,
            'titre' => $titre,
            'contenu' => $contenu,
            'idUser' => $idUser,
            'categoryIds' => $categoryIds
        ]);
    }

    // Admin seulement
    public function edit(){
        Auth::admin();

        $id = (int) ($_GET['id'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);

            View::render('error', [
                'pageTitle' => 'Article introuvable',
                'message' => 'Cet article n’existe pas.'
            ]);

            return;
        }

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAdmins();
        $categories = $categorieModel->getAll();

        $categoryIds = $postModel->getCategoryIds($id);

        View::render('post-edit', [
            'pageTitle' => 'Modifier un article',
            'idPosts' => $post['idPosts'],
            'titre' => $post['Titre'],
            'contenu' => $post['Contenu'],
            'image' => $post['Image'],
            'idUser' => $post['Users_idUsers'],
            'categoryIds' => $categoryIds,
            'users' => $users,
            'categories' => $categories
        ]);
    }

    // Admin seulement
    public function update(){
        Auth::admin();

        $id = (int) ($_POST['idPosts'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);

            View::render('error', [
                'pageTitle' => 'Article introuvable',
                'message' => 'Cet article n’existe pas.'
            ]);

            return;
        }

        $titre = trim($_POST['Titre'] ?? '');
        $contenu = trim($_POST['Contenu'] ?? '');
        $idUser = (int) ($_POST['Users_idUsers'] ?? 0);

        $categoryIds = $_POST['categories'] ?? [];

        // Image téléversée (facultative)
        $image = $_FILES['Image'] ?? null;

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAdmins();
        $categories = $categorieModel->getAll();

        $errors = [];

        if ($titre === '') {
            $errors[] = 'Le titre est obligatoire.';
        } elseif (mb_strlen($titre) > 255) {
            $errors[] = 'Le titre doit contenir au maximum 255 caractères.';
        }

        if ($contenu === '') {
            $errors[] = 'Le contenu est obligatoire.';
        }

        $userIds = array_map(
            'intval',
            array_column($users, 'idUsers')
        );

        if (!in_array($idUser, $userIds, true)) {
            $errors[] = 'Choisis un auteur valide.';
        }

        if (!is_array($categoryIds)) {
            $errors[] = 'Les catégories sont invalides.';
            $categoryIds = [];
        }

        $categoryIds = array_unique(
            array_map('intval', $categoryIds)
        );

        $validCategoryIds = array_map(
            'intval',
            array_column($categories, 'idCategories')
        );

        if (array_diff($categoryIds, $validCategoryIds)) {
            $errors[] = 'Une catégorie sélectionnée est invalide.';
        }

        $imageError = Upload::validateImage($image);

        if ($imageError) {
            $errors[] = $imageError;
        }

        if (!$errors) {
            try {
                // On garde l'image actuelle, sauf si on la remplace ou la retire
                $imageName = $post['Image'];

                if (Upload::hasFile($image)) {
                    $imageName = Upload::saveImage($image);
                } elseif (isset($_POST['RemoveImage'])) {
                    $imageName = null;
                }

                $postModel->updatePost($id, [
                    'Titre' => $titre,
                    'Contenu' => $contenu,
                    'Image' => $imageName,
                    'Users_idUsers' => $idUser,
                    'update_at' => date('Y-m-d H:i:s')
                ], $categoryIds);

                // L'ancienne image n'est plus utilisée : on la supprime
                if ($imageName !== $post['Image']) {
                    Upload::deleteImage($post['Image']);
                }

                View::redirect(
                    'article?id=' . $id,
                    'L’article a été modifié avec succès.'
                );
            } catch (PDOException $e) {
                $errors[] = 'Impossible de modifier l’article pour le moment.';
            } catch (RuntimeException $e) {
                $errors[] = 'Impossible de modifier l’article pour le moment.';
            }
        }

        View::render('post-edit', [
            'pageTitle' => 'Modifier un article',
            'idPosts' => $id,
            'titre' => $titre,
            'contenu' => $contenu,
            'image' => $post['Image'],
            'idUser' => $idUser,
            'categoryIds' => $categoryIds,
            'users' => $users,
            'categories' => $categories,
            'errors' => $errors
        ]);
    }

    // Admin seulement
    public function destroy(){
        Auth::admin();

        $id = (int) ($_POST['id'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            View::redirect(
                'admin',
                'Article introuvable : aucune suppression effectuée.'
            );
        }

        try {
            $postModel->deletePost($id);

            // On supprime aussi l'image de l'article
            Upload::deleteImage($post['Image']);

            View::redirect(
                'admin',
                'L’article a été supprimé avec succès.'
            );
        } catch (PDOException $e) {
            View::redirect(
                'admin',
                'Impossible de supprimer l’article pour le moment.'
            );
        } catch (RuntimeException $e) {
            View::redirect(
                'admin',
                'Impossible de supprimer l’article pour le moment.'
            );
        }
    }
}
