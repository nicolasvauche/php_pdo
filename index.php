<?php
// Classe BDD requise
require_once('classes/User.php');

// Initialisation des données exemple
$userData = [
    'prenom' => 'Bob',
    'nom' => 'Marley',
];

// On sécurise une opération qui pourrait très probablement créer une exception
try {
    // Création d'un User
    $userObject = new User($userData);
    $user = $userObject->addUser();
    echo "<p>{$user->getPrenom()} {$user->getNom()} a été ajouté</p>";
} catch (PDOException $e) {
    // L'exception levée par PDO est correctement captée ici
    $dbco->rollBack();
    echo "<p>Une Exception a été levée :(<br />" . $e->getMessage() . "</p>";
}
