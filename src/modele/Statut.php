<?php

class Statut {
    private ?int $id_statut = null;
    private string $nom;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id'])) $this->setIdStatut((int) $data['id']);
        if (isset($data['nom'])) $this->setNom($data['nom']);
    }

    public function getIdStatut(): ?int { return $this->id_statut; }
    public function setIdStatut(int $id_statut): void { $this->id_statut = $id_statut; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
}