<?php

require_once __DIR__ . '/../modele/Canton.php';
require_once __DIR__ . '/../modele/Metier.php';
require_once __DIR__ . '/../modele/Genre.php';
require_once __DIR__ . '/../modele/Statut.php';
require_once __DIR__ . '/../modele/Role.php';

class ReferenceRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Récupère tous les cantons dans l'ordre géographique (du nord au sud).
     * @return Canton[]
     */
    public function getCantons(): array {
        $sql = "SELECT id, nom
                FROM canton
                ORDER BY FIELD(nom, 'Jura', 'Berne', 'Neuchâtel', 'Fribourg', 'Vaud', 'Valais', 'Genève'), nom";
        $stmt = $this->db->query($sql);

        $cantons = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cantons[] = new Canton($data);
        }
        return $cantons;
    }

    /**
     * Récupère tous les métiers (triés par ID).
     * @return Metier[]
     */
    public function getMetiers(): array {
        $sql = "SELECT id, nom FROM metier ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        $metiers = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $metiers[] = new Metier($data);
        }
        return $metiers;
    }

    /**
     * Récupère tous les genres musicaux (ordre alphabétique).
     * @return Genre[]
     */
    public function getGenres(): array {
        $sql = "SELECT id, nom FROM genre ORDER BY nom ASC";
        $stmt = $this->db->query($sql);

        $genres = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genres[] = new Genre($data);
        }
        return $genres;
    }

    /**
     * Récupère tous les statuts.
     * @return Statut[]
     */
    public function getStatuts(): array {
        $sql = "SELECT id, nom FROM statut ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        $statuts = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $statuts[] = new Statut($data);
        }
        return $statuts;
    }

    /**
     * Récupère tous les rôles.
     * @return Role[]
     */
    public function getRoles(): array {
        $sql = "SELECT id, nom FROM role ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        $roles = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roles[] = new Role($data);
        }
        return $roles;
    }
}