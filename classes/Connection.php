<?php
// Class Json is required
require_once('utils/json.php');

/**
 * Connection
 *
 * This class generates and returns a PDO database connection
 */
class Connection
{
    /**
     * Connection constructor
     *
     * This function reads the bdd.json configuration file as JSON,
     * Generates a new PDO connection to a MySQL database, and returns it as PDO object
     *
     * @return PDO
     */
    public function __construct()
    {
        if (!$connData = fileJsonToArray('config/bdd.json')) {
            die('<p>Connexion à la BDD KO : Format du fichier de configuration incorrect :(</p>');
        }

        try {
            $dbco = new PDO("mysql:host={$connData['servname']};dbname={$connData['dbname']}", $connData['user'], $connData['pass']);
            $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p>Connexion à la BDD OK :)";
        } catch (PDOException $e) {
            die("<p>Une Exception a été levée :(<br />" . $e->getMessage() . "</p>");
        }
        
        return $dbco;
    }
}