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
    <style>
  
        
        :root {
            --bg-color: #000000;
            --card-bg: #151515;
            --text-main: #ffffff;
            --input-bg: #e6e6e6; 
            --input-text: #333333;
            --btn-bg: #74a89c; 
            --btn-hover: #5d8b80;
            --error-color: #ff6b6b;
            --success-color: #51cf66;
            --font-family: 'Helvetica Neue', Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: var(--font-family);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        
        .auth-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .auth-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .auth-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-btn {
            color: var(--text-main);
            text-decoration: none;
            font-size: 24px;
            margin-right: 15px;
            line-height: 1;
        }

        .auth-title {
            font-size: 28px;
            font-weight: bold;
        }

       
        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border-radius: 30px; 
            border: none;
            background-color: var(--input-bg);
            color: var(--input-text);
            font-size: 16px;
            font-family: inherit;
        }

        .form-control::placeholder {
            color: #888888;
        }

        .form-control:focus {
            outline: 2px solid var(--btn-bg);
        }

        /* Classes de bouton */
        .btn {
            display: inline-block;
            width: 100%;
            padding: 15px 20px;
            border-radius: 30px;
            border: none;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: var(--btn-bg);
            color: var(--text-main);
        }

        .btn-primary:hover {
            background-color: var(--btn-hover);
        }

        /* Messages d'alerte */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .alert-danger {
            background-color: rgba(255, 107, 107, 0.2);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }
        .alert-success {
            background-color: rgba(81, 207, 102, 0.2);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }
    </style>
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