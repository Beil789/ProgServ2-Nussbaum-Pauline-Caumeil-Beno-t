<?php

class Canton {
    private ?int $id_canton = null;
    private string $nom;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id_canton'])) $this->setIdCanton((int) $data['id_canton']);
        if (isset($data['nom'])) $this->setNom($data['nom']);
    }

    public function getIdCanton(): ?int { return $this->id_canton; }
    public function setIdCanton(int $id_canton): void { $this->id_canton = $id_canton; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }
}