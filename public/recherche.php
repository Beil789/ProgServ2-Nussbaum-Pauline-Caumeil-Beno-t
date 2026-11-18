<?php

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function selectedIds(string $key): array
{
    $values = $_GET[$key] ?? [];
    if (!is_array($values)) {
        return [];
    }

    $ids = [];
    foreach ($values as $value) {
        $id = filter_var($value, FILTER_VALIDATE_INT);
        if ($id !== false && $id > 0) {
            $ids[] = $id;
        }
    }

    return array_values(array_unique($ids));
}

function renderFilterOptions(array $options, string $name, array $selected, string $style, array $labels = []): void
{
    foreach ($options as $option) {
        $id = (int) $option['id'];
        $label = $labels[$option['nom']] ?? $option['nom'];
        ?>
        <label class="filter-chip filter-chip--<?= escapeHtml($style) ?>">
            <input type="checkbox" name="<?= escapeHtml($name) ?>[]" value="<?= $id ?>"
                <?= in_array($id, $selected, true) ? 'checked' : '' ?>>
            <span><?= escapeHtml($label) ?></span>
        </label>
        <?php
    }
}

$selectedCantons = selectedIds('canton');
$selectedMetiers = selectedIds('metier');
$selectedGenres = selectedIds('genre');
$searchTerm = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';

$cantons = [];
$metiers = [];
$genres = [];
$artists = [];
$databaseError = null;

try {
    $config = parse_ini_file(__DIR__ . '/../src/config/database.ini');
    if ($config === false) {
        throw new RuntimeException('La configuration de la base de données est illisible.');
    }

    $pdo = new PDO(
        "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    $cantons = $pdo->query(
        "SELECT id, nom FROM canton
         ORDER BY FIELD(nom, 'Jura', 'Berne', 'Neuchâtel', 'Fribourg', 'Vaud', 'Valais', 'Genève'), nom"
    )->fetchAll();
    $metiers = $pdo->query('SELECT id, nom FROM metier ORDER BY id')->fetchAll();
    $genres = $pdo->query('SELECT id, nom FROM genre ORDER BY id')->fetchAll();

    $conditions = ["s.nom = :published_status"];
    $parameters = [':published_status' => 'publié'];

    $filters = [
        'a.id_canton' => $selectedCantons,
        'a.id_metier' => $selectedMetiers,
    ];

    foreach ($filters as $column => $ids) {
        if ($ids === []) {
            continue;
        }

        $placeholders = [];
        foreach ($ids as $index => $id) {
            $parameter = ':' . str_replace('.', '_', $column) . '_' . $index;
            $placeholders[] = $parameter;
            $parameters[$parameter] = $id;
        }
        $conditions[] = $column . ' IN (' . implode(', ', $placeholders) . ')';
    }

    if ($selectedGenres !== []) {
        $placeholders = [];
        foreach ($selectedGenres as $index => $id) {
            $parameter = ':genre_' . $index;
            $placeholders[] = $parameter;
            $parameters[$parameter] = $id;
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
        $searchValue = '%' . $searchTerm . '%';
        $parameters[':artist_name'] = $searchValue;
        $parameters[':artist_locality'] = $searchValue;
        $parameters[':artist_postal_code'] = $searchValue;
    }

    $sql = 'SELECT a.id, a.nom, a.photo, a.localite, a.npa, c.nom AS canton, m.nom AS metier
            FROM artiste a
            INNER JOIN canton c ON c.id = a.id_canton
            INNER JOIN metier m ON m.id = a.id_metier
            INNER JOIN statut s ON s.id = a.id_statut
            WHERE ' . implode(' AND ', $conditions) . '
            ORDER BY a.nom ASC';
    $statement = $pdo->prepare($sql);
    $statement->execute($parameters);
    $artists = $statement->fetchAll();
} catch (PDOException | RuntimeException $exception) {
    error_log('Erreur sur recherche.php : ' . $exception->getMessage());
    $databaseError = 'La recherche est momentanément indisponible. Veuillez réessayer plus tard.';
}

$professionLabels = [
    'Chanteur' => 'Chanteur·euse',
    'Rappeur' => 'Rappeur·euse',
    'Musicien' => 'Musicien·ne',
    'Producteur' => 'Producteur·rice',
    'Autre' => 'Autres',
];
$genreLabels = [
    'Electronique' => 'Electro',
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recherche — LE SCOPE</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="index.php" aria-label="LE SCOPE, accueil">LE SCOPE</a>
        <nav class="main-nav" aria-label="Navigation principale">
            <a href="index.php#genre">Genre</a>
            <a href="index.php#metiers">Métiers</a>
            <a href="index.php#map">Map</a>
        </nav>
        <a class="login-link" href="inscription.php">Se connecter</a>
    </header>

    <main>
        <form class="search-form" method="get" action="recherche.php">
            <div class="search-box">
                <input type="search" name="q" value="<?= escapeHtml($searchTerm) ?>"
                    placeholder="Rechercher un·e créateur·rice..." aria-label="Rechercher un artiste">
                <button class="search-submit" type="submit" aria-label="Lancer la recherche">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="10.8" cy="10.8" r="6.3"></circle>
                        <path d="m15.5 15.5 4.2 4.2"></path>
                    </svg>
                </button>
            </div>

            <section class="filter-group" aria-label="Filtrer par canton">
                <div class="filter-options">
                    <?php renderFilterOptions($cantons, 'canton', $selectedCantons, 'region'); ?>
                </div>
            </section>

            <section class="filter-group" aria-label="Filtrer par genre musical">
                <div class="filter-options">
                    <?php renderFilterOptions($genres, 'genre', $selectedGenres, 'genre', $genreLabels); ?>
                </div>
            </section>

            <section class="filter-group" aria-label="Filtrer par métier">
                <div class="filter-options">
                    <?php renderFilterOptions($metiers, 'metier', $selectedMetiers, 'profession', $professionLabels); ?>
                </div>
                <div class="filter-actions">
                    <button class="apply-filters" type="submit">Appliquer les filtres</button>
                </div>
            </section>
        </form>

        <div class="results-heading">
            <h1><?= count($artists) ?> résultat<?= count($artists) === 1 ? '' : 's' ?></h1>
            <?php if ($selectedCantons !== [] || $selectedMetiers !== [] || $selectedGenres !== [] || $searchTerm !== ''): ?>
                <a class="clear-filters" href="recherche.php">Effacer les filtres</a>
            <?php endif; ?>
        </div>

        <?php if ($databaseError !== null): ?>
            <p class="error-state"><?= escapeHtml($databaseError) ?></p>
        <?php elseif ($artists === []): ?>
            <p class="empty-state">Aucun artiste ne correspond à votre recherche. Essayez d’autres filtres.</p>
        <?php else: ?>
            <section class="artist-grid" aria-label="Résultats de la recherche">
                <?php foreach ($artists as $artist): ?>
                    <article class="artist-card">
                        <div class="artist-portrait">
                            <?php if (!empty($artist['photo'])): ?>
                                <img src="<?= escapeHtml($artist['photo']) ?>" alt="Photo de <?= escapeHtml($artist['nom']) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="portrait-placeholder" aria-hidden="true"></div>
                            <?php endif; ?>
                        </div>
                        <h2 class="artist-name"><?= escapeHtml($artist['nom']) ?></h2>
                        <p class="artist-profession"><?= escapeHtml($artist['metier']) ?></p>
                        <div class="artist-meta">
                            <span class="artist-location">
                                <?= escapeHtml((string) ($artist['npa'] ?? '')) ?>
                                <?= escapeHtml((string) ($artist['localite'] ?? '')) ?><br>
                                <?= escapeHtml($artist['canton']) ?>
                            </span>
                            <span class="card-icons" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.6">
                                    <path d="M6 3.5h12v17l-6-4-6 4z"></path>
                                </svg>
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.6">
                                    <path d="M20.5 8.8c0 5-8.5 10-8.5 10s-8.5-5-8.5-10a4.5 4.5 0 0 1 8.5-2.1 4.5 4.5 0 0 1 8.5 2.1z"></path>
                                </svg>
                            </span>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>

    <footer class="site-footer">
        <span>Projet réalisé par Benoît Caumeil et Pauline Nussbaum dans le cadre du cours ProgServ2 à la HEIG-VD</span>
        <span class="language-links"><a href="recherche.php" aria-current="page">FR</a><a href="recherche.php">EN</a></span>
    </footer>
</body>
</html>
