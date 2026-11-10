<?php

namespace App\Providers;

class Auth {

    // Démarre une session sécurisée (cookie inaccessible au JavaScript)
    static public function start(){
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            session_start();
        }
    }

    // Empreinte du navigateur pour empêcher le vol de session
    static private function fingerPrint(){
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';

        return hash('sha256', $userAgent . $ip);
    }

    // Enregistre l'utilisateur dans la session après la connexion
    static public function login($user){
        // Nouvel identifiant de session pour éviter la fixation de session
        session_regenerate_id(true);

        $_SESSION['userId'] = $user['idUsers'];
        $_SESSION['userName'] = $user['Username'];
        $_SESSION['userRole'] = $user['Role'];
        $_SESSION['fingerPrint'] = self::fingerPrint();
    }

    // Détruit la session
    static public function logout(){
        $_SESSION = [];

        session_regenerate_id(true);
        session_destroy();
    }

    // Vrai si un utilisateur est connecté avec la bonne empreinte
    static public function check(){
        if (!isset($_SESSION['userId'], $_SESSION['fingerPrint'])) {
            return false;
        }

        return $_SESSION['fingerPrint'] === self::fingerPrint();
    }

    // Vrai si l'utilisateur connecté est un administrateur
    static public function isAdmin(){
        return self::check() && $_SESSION['userRole'] === 'admin';
    }

    // Page protégée : il faut être connecté (client ou admin)
    static public function session(){
        if (!self::check()) {
            View::redirect(
                'login',
                'Connectez-vous pour accéder à cette page.'
            );
        }
    }

    // Page protégée : il faut être administrateur
    static public function admin(){
        self::session();

        if (!self::isAdmin()) {
            http_response_code(403);

            View::render('error', [
                'pageTitle' => 'Accès refusé',
                'message' => 'Vous n’avez pas les droits pour accéder à cette page.'
            ]);

            exit;
        }
    }
}
