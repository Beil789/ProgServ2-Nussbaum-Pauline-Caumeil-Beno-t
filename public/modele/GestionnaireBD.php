<?php
require_once 'User.php';
require_once 'Artiste.php';
require_once 'Canton.php';
require_once 'Metier.php';
require_once 'Genre.php';


class GestionnaireBD {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Ajoute un utilisateur et renvoie son ID si succès (ou 0 / null si échec)
     
    public function createUser(User $user): int {
        $sql = "INSERT INTO utilisateur (username,email, mot_de_passe, id_role) 
                VALUES (:username, :email, :mot_de_passe, :id_role)";
        
        $stmt = $this->db->prepare($sql);
        
        $result = $stmt->execute([
            ':username'        => $user->getUsername(),
            ':email'        => $user->getEmail(),
            ':mot_de_passe' => $user->getMotDePasse(), 
            ':id_role'      => $user->getIdRole()
        ]);

        if ($result) {
            // Renvoie le nouvel ID créé par MySQL
            return (int)$this->db->lastInsertId();
        }

        return 0; // 0 signifie que l'insertion a échoué
    }

    public function createArtiste(Artiste $artiste): int {
        $sql = "INSERT INTO ARTISTE (
                    nom, email_contact, description, photo, npa, localite, 
                    url_insta, url_facebook, url_tiktok, id_user, id_metier, id_canton
                ) VALUES (
                    :nom, :email_contact, :description, :photo, :npa, :localite, 
                    :url_insta, :url_facebook, :url_tiktok, :id_user, :id_metier, :id_canton
                )";
        
        $stmt = $this->db->prepare($sql);
        
        $result = $stmt->execute([
            ':nom'           => $artiste->getNom(),
            ':email_contact' => $artiste->getEmailContact(),
            ':description'   => $artiste->getDescription(),
            ':photo'         => $artiste->getPhoto(),
            ':npa'           => $artiste->getNpa(),
            ':localite'      => $artiste->getLocalite(),
            ':url_insta'     => $artiste->getUrlInsta(),
            ':url_facebook'  => $artiste->getUrlFacebook(),
            ':url_tiktok'    => $artiste->getUrlTiktok(),
            ':id_user'       => $artiste->getIdUser(),
            ':id_metier'     => $artiste->getIdMetier(),
            ':id_canton'     => $artiste->getIdCanton()
        ]);

        if ($result) {
            
            return (int)$this->db->lastInsertId();
        }

        return 0; 
    }

    
     // Récupère la liste de tous les cantons (triés par ordre alphabétique)
    
    public function getCantons(): array {
        $sql = "SELECT * FROM CANTON ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        
        $cantons = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cantons[] = new Canton($data);
        }
        return $cantons;
    }

    //Récupère la liste de tous les métiers disponibles
    public function getMetiers(): array {
        $sql = "SELECT * FROM METIER ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        
        $metiers = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $metiers[] = new Metier($data);
        }
        return $metiers;
    }

    
     //Récupère la liste de tous les genres musicaux
    public function getGenres(): array {
        $sql = "SELECT * FROM GENRE ORDER BY nom ASC";
        $stmt = $this->db->query($sql);
        
        $genres = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genres[] = new Genre($data);
        }
        return $genres;
    }

}