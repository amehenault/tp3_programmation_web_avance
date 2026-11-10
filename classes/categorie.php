<?php

class Categorie
{
    private ?int $id;
    private string $nom;

    public function __construct(
        string $nom,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}