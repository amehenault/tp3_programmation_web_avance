<?php

class Post
{
    private ?int $id;
    private string $titre;
    private string $contenu;
    private int $idUser;

    public function __construct(
        string $titre,
        string $contenu,
        int $idUser,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->idUser = $idUser;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }
}