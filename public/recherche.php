<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../src/repositories/ReferenceRepository.php';
require_once __DIR__ . '/../src/repositories/ArtisteRepository.php';

function selectedIds(string $key): array
{
    $values = $_GET[$key] ?? [];

    // Accepte aussi bien ?canton=1 (depuis la map) que ?canton[]=1&canton[]=2 (depuis le formulaire)
    if (!is_array($values)) {
        $values = [$values];
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

function renderFilterOptions(array $options, callable $getId, string $name, array $selected, string $style, array $labels = []): void
{
    foreach ($options as $option) {
        $id = (int) $getId($option);
        $nom = $option->getNom();
        $label = $labels[$nom] ?? $nom;
        ?>
        <label class="filter-chip filter-chip--<?= htmlspecialchars($style, ENT_QUOTES, 'UTF-8') ?>">
            <input type="checkbox" name="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>[]" value="<?= $id ?>"
                <?= in_array($id, $selected, true) ? 'checked' : '' ?>>
            <span><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
        </label>
        <?php
    }
}

$selectedCantons = selectedIds('canton');
$selectedMetiers = selectedIds('metier');
$selectedGenres  = selectedIds('genre');
$searchTerm      = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';

$cantons = [];
$metiers = [];
$genres  = [];
$artists = [];
$databaseError = null;

$allSelected = $cantons !== []
    && $genres !== []
    && $metiers !== []
    && count($selectedCantons) === count($cantons)
    && count($selectedGenres) === count($genres)
    && count($selectedMetiers) === count($metiers);

try {
    require_once __DIR__ . '/../src/config/database.php';

    $refRepo     = new ReferenceRepository($bdd);
    $artisteRepo = new ArtisteRepository($bdd);

    $cantons = $refRepo->getCantons();
    $metiers = $refRepo->getMetiers();
    $genres  = $refRepo->getGenres();
    $artists = $artisteRepo->search($selectedCantons, $selectedMetiers, $selectedGenres, $searchTerm);
} catch (PDOException | RuntimeException $exception) {
    error_log('Erreur sur recherche.php : ' . $exception->getMessage());
    $databaseError = 'La recherche est momentanément indisponible. Veuillez réessayer plus tard.';
}

$professionLabels = [
    'Chanteur'   => 'Chanteur·euse',
    'Rappeur'    => 'Rappeur·euse',
    'Musicien'   => 'Musicien·ne',
    'Producteur' => 'Producteur·rice',
    'Autre'      => 'Autres',
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
     <link rel="stylesheet" href="css/recherchestyle.css">
     <script type="module" src="js/recherche.js"></script>
</head>
<body>
 <?php include 'view/header.php'; ?>

    <main>
        <form class="search-form" method="get" action="recherche.php">
            <div class="search-box">
                <input type="search" name="q" value="<?= htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') ?>"
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
                    <?php renderFilterOptions($cantons, fn(Canton $c) => $c->getIdCanton(), 'canton', $selectedCantons, 'region'); ?>
                </div>
            </section>

            <section class="filter-group" aria-label="Filtrer par genre musical">
                <div class="filter-options">
                    <?php renderFilterOptions($genres, fn(Genre $g) => $g->getIdGenre(), 'genre', $selectedGenres, 'genre', $genreLabels); ?>
                </div>
            </section>

            <section class="filter-group" aria-label="Filtrer par métier">
                <div class="filter-options">
                    <?php renderFilterOptions($metiers, fn(Metier $m) => $m->getIdMetier(), 'metier', $selectedMetiers, 'profession', $professionLabels); ?>
                </div>
            <div class="filter-actions">
    <button
        type="button"
        id="toggle-all-filters"
        class="apply-filters<?= $allSelected ? ' is-active' : '' ?>"
        aria-pressed="<?= $allSelected ? 'true' : 'false' ?>"
    >
        Tout sélectionner
    </button>
</div>
            </section>
        </form>

<div class="results-heading">
    <h1><?= count($artists) ?> résultat<?= count($artists) === 1 ? '' : 's' ?></h1>
    <a class="clear-filters" href="recherche.php">Effacer les filtres</a>
</div>

        <?php if ($databaseError !== null): ?>
            <p class="error-state"><?= htmlspecialchars($databaseError, ENT_QUOTES, 'UTF-8') ?></p>
        <?php elseif ($artists === []): ?>
            <p class="empty-state">Aucun artiste ne correspond à votre recherche. Essayez d’autres filtres.</p>
        <?php else: ?>
            <section class="artist-grid" aria-label="Résultats de la recherche">
                <?php foreach ($artists as $artist): ?>
                    <article class="artist-card">
                        <div class="artist-portrait">
                            <?php if (!empty($artist['photo'])): ?>
                                <img src="<?= htmlspecialchars($artist['photo'], ENT_QUOTES, 'UTF-8') ?>" alt="Photo de <?= htmlspecialchars($artist['nom'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                            <?php else: ?>
                                <div class="portrait-placeholder" aria-hidden="true"></div>
                            <?php endif; ?>
                        </div>
                        <h2 class="artist-name"><?= htmlspecialchars($artist['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <p class="artist-profession"><?= htmlspecialchars($artist['metier'], ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="artist-meta">
                            <span class="artist-location">
                                <?= htmlspecialchars((string) ($artist['npa'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                <?= htmlspecialchars((string) ($artist['localite'] ?? ''), ENT_QUOTES, 'UTF-8') ?><br>
                                <?= htmlspecialchars($artist['canton'], ENT_QUOTES, 'UTF-8') ?>
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
  <?php include 'view/footer.php'; ?>
</body>
</html>