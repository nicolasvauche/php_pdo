<?php
// Classe BDD requise
require_once('classes/User.php');

// Initialisation des données exemple
$userData = [
    'id' => 10,
];

// On sécurise une opération qui pourrait très probablement créer une exception
try {
    // Récupération d'un User
    $user = new User($userData);
    if ($user->getPrenom() || $user->getNom()) {
        echo "<p>{$user->getPrenom()} {$user->getNom()} a été trouvé pour l'id #{$userData['id']}</p>";
    } else {
        echo "<p>Personne n'a été trouvé pour l'id #{$userData['id']}</p>";
    }
} catch (PDOException $e) {
    // L'exception levée par PDO est correctement captée ici
    $dbco->rollBack();
    echo "<p>Une Exception a été levée :(<br />" . $e->getMessage() . "</p>";
}
