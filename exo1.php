<?php
abstract class Vehicule
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;
    protected $freinmain = TRUE;

    // On oblige les classes filles à définir les méthodes abstracts
    abstract function demarrer();
    abstract function eteindre();
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    abstract function mettrefreinmain();
    abstract function enleverfreinmain();
    abstract function freinmainEtat();

    // On définit la méthode magique afin de pouvoir afficher les Véhicules
    // Ce toString sera à compléter dans les classes filles
    public function __toString()
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

class Voiture extends Vehicule
{
    const VITESSE_MAX = 360;
    private static $_compteur = 0;

    public function mettrefreinmain()
    {
        $this->freinmain = TRUE;

        // Je pars du principe ou dans un cas abstrait lorsque le véhicule active le frein a main il arrivera forcément à 0 Km/h
        $this->setVitesse(0);
    }

    public function enleverfreinmain()
    {
        $this->freinmain = FALSE;
    }

    public function freinmainEtat()
    {
        return $this->freinmain;
    }



    public static function getNombreVoiture()
    {
        return self::$_compteur;
    }

    public function __construct($vMax)
    {
        $this->setVitesseMax($vMax);
        self::$_compteur++;
    }

    public function demarrer()
    {
        $this->demarrer = TRUE;
    }

    public function eteindre()
    {
        $this->demarrer = FALSE;
    }

    public function estDemarre()
    {
        return $this->demarrer;
    }


    public function accelerer($vitesse)
    {
        if ($this->estDemarre() && !$this->freinmainEtat()) {
            if ($this->getVitesse() == 0) {


                if ($vitesse >= 0 && $vitesse <= 10) {
                    $this->setVitesse($vitesse);
                } else {
                    $this->setVitesse(10);
                }


            } elseif ($vitesse > 20) {
                $this->setVitesse($this->getVitesse() + 20);
            } else {
                $this->setVitesse($this->getVitesse() + $vitesse);
            }
        }
    }

    public function decelerer($vitesse)
    {
        if ($this->estDemarre()) {
            if ($vitesse > 20) {
                $this->setVitesse($this->getVitesse() - 20);
            } else if ($vitesse < 0) {
                $this->setVitesse($this->getVitesse());
            } else {
                $this->setVitesse($this->getVitesse() - $vitesse);
            }

        }
    }

    public function setVitesseMax($vMax)
    {

        if ($vMax > self::VITESSE_MAX) {
            $this->vitesseMax = self::VITESSE_MAX;
        } elseif ($vMax > 0) {
            $this->vitesseMax = $vMax;
        } else {
            $this->vitesseMax = 0;
        }
    }

    public function setVitesse($vitesse)
    {

        if ($vitesse > $this->getVitesseMax()) {
            $this->vitesse = $this->getVitesseMax();
        } elseif ($vitesse > 0) {
            $this->vitesse = $vitesse;
        } else {
            $this->vitesse = 0;
        }
    }

    public function getVitesse()
    {
        return $this->vitesse;
    }

    public function getVitesseMax()
    {
        return $this->vitesseMax;
    }

    public function __toString()
    {
        $chaine = parent::__toString();
        $chaine .= "La voiture a une vitesse maximale de " . $this->vitesseMax . " km/h <br/>";
        if ($this->demarrer) {
            $chaine .= "Elle est démarrée <br/>";
            $chaine .= "Sa vitesse est actuellement de " . $this->getVitesse() . "km/h <br/>";
            if ($this->freinmain) {
                $chaine .= "Frein à main activé <br/>";
            } else {
                $chaine .= "Frein à main désactiver <br/>";
            }
        } else {
            $chaine .= "Elle est arretée <br/>";
        }
        return $chaine;
    }
}

$veh1 = new Voiture(110);
$veh1->demarrer();
$veh1->accelerer(10);
echo $veh1;
$veh1->enleverfreinmain();
$veh1->accelerer(10);
echo $veh1;
$veh1->mettrefreinmain();
$veh1->accelerer(10);
echo $veh1;
$veh1->accelerer(10);
echo $veh1;

// $veh1->accelerer(10);
// echo $veh1;
// $veh1->accelerer(25);
// echo $veh1;
// $veh1->accelerer(25);
// echo $veh1;
// $veh1->accelerer(25);
// echo $veh1;
// $veh1->decelerer(120);
// echo $veh1;
// $veh1->decelerer(120);
// echo $veh1;
// $veh2 = new Voiture(180);
// echo $veh2;

echo "########################### <br/>";
echo "Nombre de voiture instancier :" . Voiture::getNombreVoiture() . "<br/>";

?>