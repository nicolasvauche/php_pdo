<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// Initialisation des variables de configuration
require_once('utils/json.php');
if (!$dbData = fileJsonToArray('config/bdd.json')) {
    die('Connexion à la BDD KO : Fichier de configuration incorrect ou introuvable :(');
}

// Initialisation des données exemple
$userData = [
    'prenom' => 'Bob',
    'nom' => 'Marley',
];

// On sécurise la connexion à la base de données
try {
    // Allez, on tente la connection à la BDD, avec l'aide de PDO
    $dbco = new PDO("mysql:host={$dbData['servname']};dbname={$dbData['dbname']}", $dbData['user'], $dbData['pass']);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connexion à la BDD OK :)</p>";
} catch (PDOException $e) {
    // L'exception levée par PDO est correctement captée ici
    echo "<p>Erreur de connexion à la base de données :(<br />" . $e->getMessage() . "</p>";
}

// On sécurise une opération qui pourrait très probablement créer une exception
try {
    // Bon, on va tenter d'ajouter des données dans la table user. Proprement cette fois !
    $dbco->beginTransaction();
    $req = $dbco->prepare("INSERT INTO user(prenom, nom) VALUES(:prenom, :nom);");
    $req->execute($userData);
    $dbco->commit();
    echo "<p>{$userData['prenom']} {$userData['nom']} a été ajouté</p>";
} catch (PDOException $e) {
    // L'exception levée par PDO est correctement captée ici
    $dbco->rollBack();
    echo "<p>Une Exception a été levée :(<br />" . $e->getMessage() . "</p>";
}
