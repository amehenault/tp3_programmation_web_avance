<?php

require_once __DIR__ . '/../models/JournalModel.php';

use App\Providers\View;

class Route {

    private static $routes = [];

    static public function get(string $url, string $controller):void{
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

    static public function post(string $url, string $controller):void{
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

    // Enregistre la visite dans le journal de bord
    static private function log($url){
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Inconnue';

        // Nom d'utilisateur si connecté, sinon "Visiteur"
        $username = $_SESSION['userName'] ?? 'Visiteur';

        try {
            $journalModel = new JournalModel();
            $journalModel->add($ip, $username, $url);
        } catch (PDOException $e) {
            // Le site doit continuer à fonctionner même si le journal échoue
        }
    }

    static public function dispatch(){
        $url = $_SERVER['REQUEST_URI'];
        $urlPath = parse_url($url, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach(self::$routes as $route){

            if(BASE.$route['url'] == $urlPath && $route['method'] == $method){
                self::log($url);

                $controllerSegments = explode('@', $route['controller']);
                $controllerName = $controllerSegments[0];
                $methodName = $controllerSegments[1];

                $controllerInstance = new $controllerName();

                if($method == "GET" || $method == "POST"){
                    $controllerInstance->$methodName();
                }
                return;
            }

        }
        http_response_code(404);

        View::render('error', [
            'pageTitle' => 'Page introuvable',
            'message' => 'Cette page n’existe pas.'
        ]);
    }

}

?>
