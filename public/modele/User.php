<?php

class User {
    private ?int $id_user = null;
    private string $username;
    private string $email;
    private string $mot_de_passe;
    private int $id_role = 1;

    public function __construct(array $data = []) {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void {
        if (isset($data['id_user'])) $this->setIdUser((int) $data['id_user']);
        if (isset($data['username'])) $this->setUsername($data['username']);
        if (isset($data['email'])) $this->setEmail($data['email']);
        if (isset($data['mot_de_passe'])) $this->setMotDePasse($data['mot_de_passe']);
        if (isset($data['id_role'])) $this->setIdRole((int) $data['id_role']);
    }

 
    public function getIdUser(): ?int { return $this->id_user; }
    public function setIdUser(?int $id_user): void { $this->id_user = $id_user; }

    public function getUsername(): string { return $this->username; }
    public function setUsername(string $username): void { $this->username = $username; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getMotDePasse(): string { return $this->mot_de_passe; }
    public function setMotDePasse(string $mot_de_passe): void { $this->mot_de_passe = $mot_de_passe; }

    public function getIdRole(): int { return $this->id_role; }
    public function setIdRole(int $id_role): void { $this->id_role = $id_role; }
}