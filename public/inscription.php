<?php

require_once '../src/config/database.php';
require_once 'modele/GestionnaireBD.php';

$gestionnaire = new GestionnaireBD($bdd);
$erreurs = [];
$messageSucces = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['mot_de_passe'] ?? '';

    
if (strlen($username) < 2 || strlen($username) > 30) {
    $erreurs[] = "Le nom d'utilisateur doit contenir entre 2 et 30 caractères.";
}

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }
    if (strlen($password) < 8) {
        $erreurs[] = "Le mot de passe doit faire au moins 8 caractères.";
    }

  
    if (empty($erreurs)) {
        $motDePasseHache = password_hash($password, PASSWORD_DEFAULT);

        // On instancie l'objet User 
        $nouvelUser = new User([
            'username' => $username,
            'email' => $email,
            'mot_de_passe' => $motDePasseHache
        ]);

        $newId = $gestionnaire->createUser($nouvelUser);

        if ($newId > 0) {
            $messageSucces = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
          
        } else {
            $erreurs[] = "Une erreur est survenue lors de la création du compte.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire - Le Scope</title>
 <link rel="stylesheet" href="styles.css">
</head>
<body>


    <div class="auth-container">
        <div class="auth-card">
            
            <div class="auth-header">
                
                <a href="index.php" class="back-btn">&larr;</a>
                <h1 class="auth-title">S'inscrire</h1>
            </div>

            <!-- Affichage des messages PHP -->
            <?php if (!empty($erreurs)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($erreurs as $erreur): ?>
                        <p><?= $erreur ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($messageSucces)): ?>
                <div class="alert alert-success">
                    <p><?= $messageSucces ?></p>
                </div>
            <?php endif; ?>

     
            <form action="inscription.php" method="POST">

              <div class="form-group">
                    <input type="usernam" name="username" id="username" class="form-control" placeholder="Nom d'utilisateur·rice" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
                </div>

                <button type="submit" class="btn btn-primary">Se créer un compte</button>
            </form>

        </div>
    </div>

</body>
</html>