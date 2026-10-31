<?php

class Genre {
    private ?int $id_genre = null;
    private string $nom;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id_genre'])) $this->setIdGenre((int) $data['id_genre']);
        if (isset($data['nom'])) $this->setNom($data['nom']);
    }

    public function getIdGenre(): ?int { return $this->id_genre; }
    public function setIdGenre(int $id_genre): void { $this->id_genre = $id_genre; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
}