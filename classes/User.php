<?php
// Classe Connection is required
require_once('classes/Connection.php');

/**
 * User
 *
 * This class generates and returns a user
 */
class User extends Connection
{
    /**
     * PDO connection object
     * @var PDO
     */
    private $dbco;

    /**
     * User data array
     * @var array
     */
    private $prenom;
    private $nom;

    /**
     * User constructor
     *
     * This function get a PDO connexion object from its parent class,
     * If given id in the userData array : instanciates and returns an existing user from the database
     */
    public function __construct(array $userData)
    {
        $this->dbco = parent::__construct();

        $this->prenom = $userData['prenom'];
        $this->nom = $userData['nom'];

        if (isset($userData['id'])) {
            return $this;
        }
    }

    public function addUser(): self
    {
        // On sécurise une opération qui pourrait très probablement créer une exception
        try {
            $this->dbco->beginTransaction();
            $req = $this->dbco->prepare("INSERT INTO user(prenom, nom) VALUES(:prenom, :nom);");
            $req->execute([
                'prenom' => $this->prenom,
                'nom' => $this->nom,
            ]);
            $this->dbco->commit();
        } catch (PDOException $e) {
            // L'exception levée par PDO est correctement captée ici
            $this->dbco->rollBack();
            die("<p>Une Exception a été levée :(<br />" . $e->getMessage() . "</p>");
        }

        return $this;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getNom()
    {
        return $this->nom;
    }
}
