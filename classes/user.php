<?php

class User
{
    protected ?int $id;
    protected string $nom;
    protected string $email;
    protected string $role;

    public function __construct(
        string $nom,
        string $email,
        string $role = 'client',
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->role = $role;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}