<?php

class ModeleVoiture
{
    private $_id;
    private $_name;
    private $_color;
    private $_carrosserie;
    private $_portes;
    private $_volCoffre;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = "set" . $key;
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }
    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setColor($color)
    {
        $this->_color = $color;
    }

    public function getColor()
    {
        return $this->_color;
    }

    public function setCarrosserie($carrosserie)
    {
        $this->_carrosserie = $carrosserie;
    }

    public function getCarrosserie()
    {
        return $this->_carrosserie;
    }

    public function setPortes($portes)
    {
        $this->_portes = $portes;
    }

    public function getPortes()
    {
        return $this->_portes;
    }

    public function setVolCoffre($volCoffre)
    {
        $this->_volCoffre = $volCoffre;
    }

    public function getVolCoffre()
    {
        return $this->_volCoffre;
    }

    public function __toString()
    {
        $chaine = "Ceci est un véhicule : <br>";
        $chaine .= "---------------------- <br>";
        $chaine .= "Nom : " . $this->getName() . "<br> Couleur : " . $this->getColor() . "<br> Carrosserie : " . $this->getCarrosserie() . "<br> Nombres portes : " . $this->getPortes() . "<br> Volume Coffre : " . $this->getVolCoffre();

        return $chaine;
    }
}

class ManagerModeleVoiture
{
    private $_db;

    public function __construct($db)
    {
        $this->setDB($db);
    }

    public function setDB(PDO $db)
    {
        $this->_db = $db;
    }

    public function addModele(ModeleVoiture $voiture)
    {
        try {
            $req = $this->_db->prepare('INSERT INTO VOITURE (Name, Color, Carrosserie, Portes, VolCoffre) VALUES (:mName, :mColor, :mCarrosserie, :mPortes, :mVolCoffre);');
            $req->bindValue(':mName', $voiture->getName());
            $req->bindValue(':mColor', $voiture->getColor());
            $req->bindValue(':mCarrosserie', $voiture->getCarrosserie());
            $req->bindValue(':mPortes', $voiture->getPortes());
            $req->bindValue(':mVolCoffre', $voiture->getVolCoffre());
            $req->execute();
            return "L'ajout à été fait";
        } catch (PDOException $e) {
            return "Il y a eu un problème : " . $e->getMessage();
        }

    }

    // DELETE
    public function suppModele(ModeleVoiture $voiture)
    {
        try {
            $this->_db->query('DELETE FROM VOITURE WHERE Name = "' . $voiture->getName() . '"');
            return 'La suppression à été faite';
        } catch (PDOException $e) {
            return "Il y a eu un problème : " . $e->getMessage();
        }

    }

    // LIST MODELE
    public function listModele()
    {
        $requete = 'SELECT Id, Name, Color, Carrosserie, Portes, VolCoffre FROM VOITURE;';
        $resultat = $this->_db->query($requete);
        echo '<ul>';
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>N° ' . $ligne['Id'] . ' : ' . ucfirst($ligne['Name']) . " | " . ucfirst($ligne['Color']) . " | " . ucfirst($ligne['Carrosserie']) . " | " . ucfirst($ligne['Portes']) . " | " . ucfirst($ligne['VolCoffre']) . '</li>';
        }
        echo '</ul>';
    }

    // LIST MODÈLE
    public function listModèle(string $carrosserie)
    {
        $requete = 'SELECT Id, Name, Color, Carrosserie, Portes, VolCoffre FROM VOITURE WHERE Carrosserie = "' . $carrosserie;
        '';
        $resultat = $this->_db->query($requete);
        echo '<ul>';
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>N° ' . $ligne['Id'] . ' : ' . ucfirst($ligne['Name']) . " | " . ucfirst($ligne['Color']) . " | " . ucfirst($ligne['Carrosserie']) . " | " . ucfirst($ligne['Portes']) . " | " . ucfirst($ligne['VolCoffre']) . '</li>';
        }
        echo '</ul>';
    }

    public function getModele($id)
    {
        $requete = "SELECT Id, Name, Color, Carrosserie, Portes, VolCoffre FROM VOITURE WHERE Id = $id";
        $resultat = $this->_db->query($requete);
        echo '<ul>';
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>N° ' . $ligne['Id'] . ' : ' . ucfirst($ligne['Name']) . " | " . ucfirst($ligne['Color']) . " | " . ucfirst($ligne['Carrosserie']) . " | " . ucfirst($ligne['Portes']) . " | " . ucfirst($ligne['VolCoffre']) . '</li>';
        }
        echo '</ul>';
    }
}

try {
    $db = new PDO('mysql:host=127.0.0.1:3306;dbname=controle_voiture', 'root', '');
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    die();
}

$av1 = new ModeleVoiture([
    'Name' => "Ferrari",
    'Color' => 'Rouge',
    'Carrosserie' => 'Berline',
    'Portes' => 2,
    'VolCoffre' => 1515
]);



$av2 = new ModeleVoiture([
    'Name' => "Lamborghini",
    'Color' => 'Vert',
    'Carrosserie' => 'Supercar',
    'Portes' => 2,
    'VolCoffre' => 1556
]);

$av3 = new ModeleVoiture([
    'Name' => "Porsche",
    'Color' => 'Jaune',
    'Carrosserie' => 'Supercar',
    'Portes' => 2,
    'VolCoffre' => 1556
]);

$manager = new ManagerModeleVoiture($db);
// $add = $manager->addModele($av1);
// echo $add;
// $add2 = $manager->addModele($av2);
// echo $add2;
// $add3 = $manager->addModele($av3);
// echo $add3;

$manager->listModele();
//$manager->listModèle("Supercar");
//$manager->getModele(15);

// $delete = $manager->suppModele($av1);
// echo $delete;
// $delete2 = $manager->suppModele($av2);
// echo $delete2;
// $delete3 = $manager->suppModele($av3);
// echo $delete3;
?>