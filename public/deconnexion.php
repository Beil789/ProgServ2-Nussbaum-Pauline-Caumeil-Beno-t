<?php

session_start();

// Vide toutes les variables de session (user_id, username, id_role...)
$_SESSION = [];


session_destroy();


header('Location: index.php');
exit;