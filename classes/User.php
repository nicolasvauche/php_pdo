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
     * This function gets a PDO connexion object from its parent class
     * If given id in the userData array : instanciates and returns an existing user from the database
     */
    public function __construct(array $userData)
    {
        $this->dbco = parent::__construct();

        $this->prenom = isset($userData['prenom']) ? $userData['prenom'] : null;
        $this->nom = isset($userData['nom']) ? $userData['nom'] : null;
            
        if (isset($userData['id'])) {
            $req = $this->dbco->prepare("SELECT * FROM user WHERE id=:id;");
            $req->execute([
                'id' => $userData['id'],
            ]);
            $res = $req->fetchAll(PDO::FETCH_ASSOC);
            if (isset($res[0])) {
                $this->prenom = $res[0]['prenom'];
                $this->nom = $res[0]['nom'];
            } else {
                $this->prenom = null;
                $this->nom = null;
            }
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
