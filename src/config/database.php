<?php

$config = parse_ini_file('database.ini');


$host = $config['host'];
$port = $config['port']; 
$dbname = $config['database'];
$username = $config['username'];
$password = $config['password'];

try {
  
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    

    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(Exception $e) {

    die('Erreur de connexion : ' . $e->getMessage());
}
?>