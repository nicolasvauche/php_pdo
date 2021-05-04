<?php
// Initialisation des variables de configuration
$servname = 'localhost:8889';
$dbname = 'php_test';
$user = 'root';
$pass = 'root';

// Initialisation des données exemple
$userData = [
    'prenom' => 'Bob',
    'nom' => 'Marley',
];

// On sécurise une opération qui pourrait très probablement créer une exception
try {
    // Allez, on tente la connection à la BDD, avec l'aide de PDO
    $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p>Connexion à la BDD OK :)</p>";

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
