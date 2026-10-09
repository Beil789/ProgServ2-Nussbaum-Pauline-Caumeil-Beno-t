CREATE TABLE role (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE canton (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE statut (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE metier (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE NOT NULL,
    image VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE genre (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE NOT NULL,
    image VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE utilisateur (
    id SERIAL PRIMARY KEY,
    email VARCHAR(150) CHECK (email LIKE '%@%') UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    id_role INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role (id)
);

CREATE TABLE artiste (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    email_contact VARCHAR(150) CHECK (email_contact LIKE '%@%') NOT NULL,
    description TEXT,
    photo VARCHAR(255) NOT NULL,
    npa VARCHAR(4),
    localite VARCHAR(100),
    lien VARCHAR(255),
    url_insta VARCHAR(255),
    url_facebook VARCHAR(255),
    url_youtube VARCHAR(255),
    url_tiktok VARCHAR(255),
    id_utilisateur INT,
    id_metier INT NOT NULL,
    id_canton INT NOT NULL,
    id_statut INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON DELETE CASCADE,
    FOREIGN KEY (id_metier) REFERENCES metier (id),
    FOREIGN KEY (id_canton) REFERENCES canton (id),
    FOREIGN KEY (id_statut) REFERENCES statut (id)
);

CREATE TABLE likes (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_artiste INT NOT NULL,
    UNIQUE (id_utilisateur, id_artiste),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON DELETE CASCADE,
    FOREIGN KEY (id_artiste) REFERENCES artiste (id) ON DELETE CASCADE
);

CREATE TABLE favori (
    id SERIAL PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_artiste INT NOT NULL,
    UNIQUE (id_utilisateur, id_artiste),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON DELETE CASCADE,
    FOREIGN KEY (id_artiste) REFERENCES artiste (id) ON DELETE CASCADE
);

CREATE TABLE artiste_genre (
    id SERIAL PRIMARY KEY,
    id_genre INT NOT NULL,
    id_artiste INT NOT NULL,
    UNIQUE (id_artiste, id_genre),
    FOREIGN KEY (id_genre) REFERENCES genre (id) ON DELETE CASCADE,
    FOREIGN KEY (id_artiste) REFERENCES artiste (id) ON DELETE CASCADE
);
