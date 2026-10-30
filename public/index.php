<?php
$config = parse_ini_file(__DIR__ . '/../src/config/database.ini');

$dsn = "mysql:host=" . $config['host'] . ";port=" . $config['port'] . ";dbname=" . $config['database'] . ";charset=utf8mb4";

$pdo = new PDO($dsn, $config['username'], $config['password']);

$sql = "SELECT * FROM canton ORDER BY id";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Scope</title>
</head>

<body>
    <header>
        <a class ="logo" href="index.php"><img src="images/logo.png" alt="Logo"></a>
         <nav>
        <ul>
            <li><a href="genre.php">Genre</a></li> <!-- Création des pages genre métiers et map à faire encore -->
            <li><a href="metiers.php">Métiers</a></li>
            <li><a href="map.php">Map</a></li>
        </ul>
    </nav>
    <button class="button" type="button">Se connecter</button><br>
    <a href="inscription.php" class="button">S'inscrire </a>
    
    </header>
    <main>
        <div class="hero">
            <h1>LE SCOPE</h1>
            <p>L'annuaire interactif de la scène musicale en Suisse romande. Des musicien·nes<br>
            aux créateur·rices de l'ombre, découvrez et connectez-vous avec les talents de<br>votre région.</p>
            <img src="images/background.png" alt="Image de fond"> <!-- Image de fond à ajouter ici -->
            <form class="recherche" role="search" onsubmit="return false">
                <input type="text" placeholder="Rechercher un créateur.rice" />
            </form>
        </div>
        <section id="genre">
            <h2>Genres</h2>
            <div class="carrousel">
                <a class="page_rock" href="index.php">Rock</a>
                <a class="page_urbain" href="index.php">Urbain</a>
                <a class="page_pop" href="index.php">Pop</a>
                <a class="page_jazz" href="index.php">Jazz</a>
            </div>
        </section>
        <section id="metiers">
            <h2>Métiers</h2>
            <div class="carrousel">
                <a class="carte_rappeur" href="index.php">Rappeur·euse</a>
                <a class="carte_chanteur" href="index.php">Chanteur</a>
                <a class="carte_videaste" href="index.php">Vidéaste</a>
                <a class="carte_ingenieur" href="index.php">Ingénieur</a>
</section>
<section id="map">
    <h2>Map</h2>
    <img src="images/map.png" alt="Carte de la Suisse romande"> <!-- Image de la carte de la suisse à ajouter ici -->
</section>
    </main>
    <footer>
        <span>Projet réalisé par Benoît Caumeil et Pauline Nussbaum dans le cadre du cours ProgServ2 à la HEIG-VD</span>
        <span class="langues">
            <a href="index.php" aria-current="true">FR</a>
            <a href="index.php">EN</a>
        </span>
    </footer>
    <h1>ProgServ2 Course PHP Template</h1>

    <p>Bienvenue dans votre projet PHP pour le cours ProgServ2 à la HEIG-VD !</p>

    <h2>Résultats de la base de données :</h2>

    <ul>
        <?php foreach ($results as $row) { ?>
            <li>ID: <?= htmlspecialchars($row['id']) ?> - <?= htmlspecialchars($row['nom']) ?></li>
        <?php } ?>
    </ul>
</body>

</html>