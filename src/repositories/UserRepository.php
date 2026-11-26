<?php

require_once __DIR__ . '/../modele/User.php';

class UserRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Crée un utilisateur et renvoie son ID (0 si échec).
     */
    public function create(User $user): int {
        $sql = "INSERT INTO utilisateur (username, email, mot_de_passe, id_role)
                VALUES (:username, :email, :mot_de_passe, :id_role)";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':username'     => $user->getUsername(),
            ':email'        => $user->getEmail(),
            ':mot_de_passe' => $user->getMotDePasse(),
            ':id_role'      => $user->getIdRole(),
        ]);

        return $result ? (int) $this->db->lastInsertId() : 0;
    }

    /**
     * Récupère un utilisateur par son ID.
     */
    public function findById(int $id): ?User {
        $sql = "SELECT * FROM utilisateur WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    /**
     * Récupère un utilisateur par son email.
     */
    public function findByEmail(string $email): ?User {
        $sql = "SELECT * FROM utilisateur WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    /**
     * Récupère un utilisateur par son nom d'utilisateur.
     */
    public function findByUsername(string $username): ?User {
        $sql = "SELECT * FROM utilisateur WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User($data) : null;
    }

    /**
     * Vérifie si un email est déjà utilisé.
     */
    public function existsByEmail(string $email): bool {
        $sql = "SELECT 1 FROM utilisateur WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetchColumn() !== false;
    }

    /**
     * Vérifie si un username est déjà utilisé (évite une erreur SQL UNIQUE).
     */
    public function existsByUsername(string $username): bool {
        $sql = "SELECT 1 FROM utilisateur WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);

        return $stmt->fetchColumn() !== false;
    }

    /**
 * Récupère un utilisateur par son email OU son nom d'utilisateur (pour connexion.php).
 */
public function findByIdentifiant(string $identifiant): ?User {
    $sql = "SELECT * FROM utilisateur WHERE email = :email OR username = :username LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':email'    => $identifiant,
        ':username' => $identifiant,
    ]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data ? new User($data) : null;
}
}