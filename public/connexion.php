<?php

session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/repositories/UserRepository.php';

$userRepo = new UserRepository($bdd);
$erreurs = [];
$identifiant = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant'] ?? '');
    $password    = $_POST['mot_de_passe'] ?? '';

    if ($identifiant === '' || $password === '') {
        $erreurs[] = "Veuillez remplir tous les champs.";
    } else {
        try {
           
            $user = $userRepo->findByIdentifiant($identifiant);

            if ($user !== null && password_verify($password, $user->getMotDePasse())) {
                $_SESSION['user_id']  = $user->getIdUser();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['id_role']  = $user->getIdRole();

                header('Location: index.php');
                exit;
            } else {
                $erreurs[] = "Identifiant ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            error_log('Erreur connexion.php : ' . $e->getMessage());
            $erreurs[] = "Une erreur technique est survenue. Veuillez réessayer plus tard.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - Le Scope</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/connexionstyle.css">
</head>
<body>
    <?php include 'view/header.php'; ?>

    <main class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="index.php" class="back-btn" aria-label="Retour à l'accueil">&larr;</a>
                <h1 class="auth-title">Se Connecter</h1>
            </div>

            <?php if (!empty($erreurs)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($erreurs as $erreur): ?>
                        <p><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="connexion.php" method="POST">
                <div class="form-group">
                    <input type="text" name="identifiant" id="identifiant" class="form-control"
                           placeholder="Nom d'utilisateur·rice ou adresse email" autocomplete="username"
                           required value="<?= htmlspecialchars($identifiant, ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group">
                    <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control"
                           placeholder="Mot de passe" autocomplete="current-password" required>
                </div>

                <div class="auth-actions">
                    <button type="submit" class="btn btn-teal auth-submit">Valider</button>
                </div>
            </form>

            <a href="inscription.php" class="btn btn-pink btn-block auth-register">Je n'ai pas encore de compte</a>
        </div>
    </main>

    <?php include 'view/footer.php'; ?>
</body>
</html>