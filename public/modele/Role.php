<?php

class Role {
    private ?int $id_role = null;
    private string $nom;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id_role'])) $this->setIdRole((int) $data['id_role']);
        if (isset($data['nom'])) $this->setNom($data['nom']);
    }

    public function getIdRole(): ?int { return $this->id_role; }
    public function setIdRole(int $id_role): void { $this->id_role = $id_role; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
}