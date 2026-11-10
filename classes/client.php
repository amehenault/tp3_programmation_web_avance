<?php

require_once __DIR__ . '/user.php';

class Client extends User
{
    public function __construct(
        string $nom,
        string $email,
        ?int $id = null
    ) {
        parent::__construct(
            $nom,
            $email,
            'client',
            $id
        );
    }

    // Un client peut seulement lire les articles
    public function peutGererPosts(): bool
    {
        return false;
    }
}
