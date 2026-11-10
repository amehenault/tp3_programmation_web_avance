<?php

namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View {

    static public function render($template, $data = []){
        Auth::start();

        $notice = $_SESSION['notice'] ?? null;
        unset($_SESSION['notice']);

        $loader = new FilesystemLoader(__DIR__ . '/../views');

        $twig = new Environment($loader, [
            'autoescape' => 'html'
        ]);

        $twig->addGlobal('asset', ASSET);
        $twig->addGlobal('base', BASE);
        $twig->addGlobal('notice', $notice);

        // Infos de session utilisées dans le menu (connecté, admin, nom)
        $twig->addGlobal('isLogged', Auth::check());
        $twig->addGlobal('isAdmin', Auth::isAdmin());
        $twig->addGlobal('userName', $_SESSION['userName'] ?? null);

        echo $twig->render($template . '.php', $data);
    }

    static public function redirect($url, $message = null){
        if ($message !== null) {
            Auth::start();

            $_SESSION['notice'] = $message;
        }

        header('Location: ' . BASE . '/' . $url);
        exit;
    }
}
