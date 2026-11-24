<?php

require_once __DIR__ . '/../modele/Artiste.php';

class ArtisteRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Crée un nouvel artiste et renvoie son ID (0 si échec).
     */
    public function create(Artiste $artiste): int {
        $sql = "INSERT INTO artiste (
                    nom, email_contact, description, photo, npa, localite,
                    lien, url_insta, url_facebook, url_youtube, url_tiktok,
                    id_utilisateur, id_metier, id_canton, id_statut
                ) VALUES (
                    :nom, :email_contact, :description, :photo, :npa, :localite,
                    :lien, :url_insta, :url_facebook, :url_youtube, :url_tiktok,
                    :id_utilisateur, :id_metier, :id_canton, :id_statut
                )";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            ':nom'            => $artiste->getNom(),
            ':email_contact'  => $artiste->getEmailContact(),
            ':description'    => $artiste->getDescription(),
            ':photo'          => $artiste->getPhoto() ?? '',
            ':npa'            => $artiste->getNpa(),
            ':localite'       => $artiste->getLocalite(),
            ':lien'           => $artiste->getLien(),
            ':url_insta'      => $artiste->getUrlInsta(),
            ':url_facebook'   => $artiste->getUrlFacebook(),
            ':url_youtube'    => $artiste->getUrlYoutube(),
            ':url_tiktok'     => $artiste->getUrlTiktok(),
            ':id_utilisateur' => $artiste->getIdUser(),
            ':id_metier'      => $artiste->getIdMetier(),
            ':id_canton'      => $artiste->getIdCanton(),
            ':id_statut'      => $artiste->getIdStatut(),
        ]);

        return $result ? (int) $this->db->lastInsertId() : 0;
    }

    /**
     * Récupère un artiste par son ID.
     */
    public function findById(int $id): ?Artiste {
        $sql = "SELECT * FROM artiste WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Artiste($data) : null;
    }

    /**
     * Recherche multi-filtres des artistes.
     */
    public function search(array $cantons = [], array $metiers = [], array $genres = [], string $searchTerm = ''): array {
        $conditions = ["s.nom = :published_status"];
        $parameters = [':published_status' => 'publié'];

        $filters = [
            'a.id_canton' => $cantons,
            'a.id_metier' => $metiers,
        ];

        foreach ($filters as $column => $ids) {
            if ($ids === []) {
                continue;
            }

            $placeholders = [];
            foreach ($ids as $index => $id) {
                $param = ':' . str_replace('.', '_', $column) . '_' . $index;
                $placeholders[] = $param;
                $parameters[$param] = $id;
            }
            $conditions[] = $column . ' IN (' . implode(', ', $placeholders) . ')';
        }

        if ($genres !== []) {
            $placeholders = [];
            foreach ($genres as $index => $id) {
                $param = ':genre_' . $index;
                $placeholders[] = $param;
                $parameters[$param] = $id;
            }

            $conditions[] = 'EXISTS (
                SELECT 1
                FROM artiste_genre ag
                WHERE ag.id_artiste = a.id
                  AND ag.id_genre IN (' . implode(', ', $placeholders) . ')
            )';
        }

        if ($searchTerm !== '') {
            $conditions[] = '(a.nom LIKE :artist_name OR a.localite LIKE :artist_locality OR a.npa LIKE :artist_postal_code)';
            $like = '%' . $searchTerm . '%';
            $parameters[':artist_name'] = $like;
            $parameters[':artist_locality'] = $like;
            $parameters[':artist_postal_code'] = $like;
        }

        $sql = 'SELECT a.id, a.nom, a.photo, a.localite, a.npa, c.nom AS canton, m.nom AS metier
                FROM artiste a
                INNER JOIN canton c ON c.id = a.id_canton
                INNER JOIN metier m ON m.id = a.id_metier
                INNER JOIN statut s ON s.id = a.id_statut
                WHERE ' . implode(' AND ', $conditions) . '
                ORDER BY a.nom ASC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($parameters);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}