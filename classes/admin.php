<?php

require_once __DIR__ . '/user.php';

class Admin extends User
{
    public function __construct(
        string $nom,
        string $email,
        ?int $id = null
    ) {
        parent::__construct(
            $nom,
            $email,
            'admin',
            $id
        );
    }

    public function peutGererPosts(): bool
    {
        return true;
    }
}