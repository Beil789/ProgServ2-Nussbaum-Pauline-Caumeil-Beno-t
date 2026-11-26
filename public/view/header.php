<?php
$estConnecte = !empty($_SESSION['user_id']);
?>

<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/headerviewerstyle.css">

<header class="site-header">
    <div class="header-logo">
        <a href="index.php" class="logo-text">LE SCOPE</a>
    </div>

    <nav class="header-nav">
        <ul>
            <li><a href="index.php#genre">Genres</a></li>
            <li><a href="index.php#metiers">Métiers</a></li>
            <li><a href="index.php#map">Map</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if ($estConnecte): ?>
                <li><a href="favoris.php" class="nav-favoris">Mes favoris</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="header-auth">
        <?php if ($estConnecte): ?>
            <a href="profil.php" class="header-username">
                <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>
            </a>
            <a href="deconnexion.php" class="btn-logout" title="Se déconnecter" aria-label="Se déconnecter">
                <img src="image/deconnexion.png" alt="Se déconnecter">
            </a>
        <?php else: ?>
            <a href="connexion.php" class="btn-connect">Se Connecter</a>
        <?php endif; ?>
    </div>
</header>