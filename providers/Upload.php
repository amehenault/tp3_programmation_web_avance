<?php

namespace App\Providers;

use finfo;

class Upload {

    // Types d'images acceptés et leur extension
    private static $types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif'
    ];

    // Taille maximale : 2 Mo
    private static $maxSize = 2 * 1024 * 1024;

    // Dossier où les images sont enregistrées
    static private function folder(){
        return dirname(__DIR__) . '/images/';
    }

    // Vrai si un fichier a été choisi dans le formulaire
    static public function hasFile($file){
        return isset($file['error']) && $file['error'] !== UPLOAD_ERR_NO_FILE;
    }

    // Retourne un message d'erreur, ou null si l'image est valide
    static public function validateImage($file){
        if (!self::hasFile($file)) {
            return null;
        }

        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
            return 'L’image est trop lourde (2 Mo maximum).';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'Erreur lors du téléversement de l’image.';
        }

        if ($file['size'] > self::$maxSize) {
            return 'L’image est trop lourde (2 Mo maximum).';
        }

        // On vérifie le vrai type du fichier (pas seulement son extension)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!isset(self::$types[$mime])) {
            return 'L’image doit être au format JPG, PNG, WEBP ou GIF.';
        }

        return null;
    }

    // Déplace l'image dans le dossier images et retourne son nouveau nom
    static public function saveImage($file){
        if (!self::hasFile($file)) {
            return null;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        // Nom unique pour ne jamais écraser une autre image
        $fileName = bin2hex(random_bytes(10)) . '.' . self::$types[$mime];

        if (!is_dir(self::folder())) {
            mkdir(self::folder(), 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], self::folder() . $fileName)) {
            throw new \RuntimeException('Impossible d’enregistrer l’image.');
        }

        return $fileName;
    }

    // Supprime une image du dossier images
    static public function deleteImage($fileName){
        if (!$fileName) {
            return;
        }

        $path = self::folder() . basename($fileName);

        if (is_file($path)) {
            unlink($path);
        }
    }
}
