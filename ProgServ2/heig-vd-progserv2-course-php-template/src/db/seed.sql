USE my_database;

-- Les valeurs CSV sont inserees dans les tables de staging pour validation.
CREATE TABLE IF NOT EXISTS staging_role (
    nom TEXT
);

CREATE TABLE IF NOT EXISTS staging_statut (
    nom TEXT
);

-- START TRANSACTION;

INSERT INTO roles (id, nom) VALUES 
(1, 'Administrateur'), 
(2, 'Utilisateur');

INSERT INTO statut (id, nom) VALUES 
(1, 'publié'), 
(2, 'en vérification'),
(3, 'refusé');

INSERT INTO canton (id, nom) VALUES
(1, 'Jura'),
(2, 'Neuchâtel'),
(3, 'Berne'),
(4, 'Fribourg'),
(5, 'Vaud'),
(6, 'Genève'),
(7, 'Valais');

INSERT INTO métier (id, nom) VALUES
(1, 'Chanteur'),
(2, 'Rappeur'),
(3, 'Musicien'),
(4, 'Producteur'),
(5, 'DJ'),
(6, 'Ingénieur du son'),
(7, 'Vidéaste'),
(8, 'Photographe'),
(9, 'Graphiste'),
(10, 'Autre');

INSERT INTO genre (id, nom) VALUES
(1, 'Classique'),
(2, 'Electronique'),
(3, 'Jazz'),
(4, 'Pop'),
(5, 'Rock'),
(6, 'RnB'),
(7, 'Urbain'),
(8, 'Soul');



-- COMMIT;

COPY ADD CONSTRAINTS FROM staging_role TO role (nom);
COPY ADD CONSTRAINTS FROM staging_statut TO statut (nom);

-- la copie des fichiers csv dans les tables ? 