<?php

class Metier {
    private ?int $id_metier = null;
    private string $nom;


    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id_metier'])) $this->setIdMetier((int) $data['id_metier']);
        if (isset($data['nom'])) $this->setNom($data['nom']);
    
    }

    public function getIdMetier(): ?int { return $this->id_metier; }
    public function setIdMetier(int $id_metier): void { $this->id_metier = $id_metier; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): void { $this->nom = $nom; }

}