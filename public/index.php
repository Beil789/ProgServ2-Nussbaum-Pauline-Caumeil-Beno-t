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
    <title>ProgServ2 Course PHP Template</title>
</head>

<body>
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