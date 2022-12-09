<?php

abstract class Vehicule
{
    protected $demarrer = false;
    protected $vitesse = 0;
    protected $vitesseMax;

    // On oblige les classes filles à définir les méthodes abstracts
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    public function demarrer()
    {
        $this->demarrer = true;
    }

    public function eteindre()
    {
        $this->demarrer = false;
    }

    public function estDemarre()
    {
        return $this->demarrer;
    }

    public function estEteint()
    {
        return $this->$this->demarrer;
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
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

class Avion extends Vehicule2
{

    const ALTITUDE_MAX = 40000;
    const VITESSE_MAX = 4000;

    private $_altitude;
    private $_altitudeMax;
    private $_trainaterrissagge = TRUE;


    public function __construct(int $vMax, int $aMax)
    {
        $this->setVitesseMax($vMax);
        $this->setAltitudeMax($aMax);
        $this->setAltitude(0);
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

    public function setAltitudeMax($aMax)
    {
        if ($aMax > self::ALTITUDE_MAX) {
            $this->_altitudeMax = self::ALTITUDE_MAX;
        } elseif ($aMax > 0) {
            $this->_altitudeMax = $aMax;
        } else {
            $this->_altitudeMax = 0;
        }
    }

    public function getAltitudeMax()
    {
        return $this->_altitudeMax;
    }

    public function getAltitude()
    {
        return $this->_altitude;
    }

    public function setAltitude($altitude)
    {
        if ($altitude > $this->_altitudeMax) {
            $this->_altitude = $this->_altitudeMax;
        } else if ($altitude > 0) {
            $this->_altitude = $altitude;
        } else {
            $this->_altitude = 0;
        }
    }

    public function setVitesse($vitesse)
    {
        if ($vitesse > $this->vitesseMax) {
            $this->vitesse = $this->vitesseMax;
        } elseif ($vitesse > 0) {
            $this->vitesse = $vitesse;
        } else {
            $this->vitesse = 0;
        }
    }


    public function setTrain()
    {
        if ($this->_trainaterrissagge) {
            $this->_trainaterrissagge = TRUE;
        } else {
            $this->_trainaterrissagge = FALSE;
        }
    }

    public function getTrain()
    {
        if ($this->_trainaterrissagge) {
            return "Sorti";
        } else {
            return 'Ranger';
        }
    }

    public function decoller()
    {
        if ($this->estDemarre() && $this->getVitesse() < 130) {
            $this->setAltitude(0);
            trigger_error('On ne peut décoller qu\'à parrttir de 130 km/h !', E_USER_WARNING);
        } else {
            $this->setAltitude(80);
        }
    }

    public function atterrir()
    {
        if ($this->getVitesse() > 80 && $this->getVitesse() < 100 && $this->getAltitude() > 50 && $this->getAltitude() < 150) {
            $this->setAltitude(0);
            $this->setVitesse(0);
        }
    }

    public function prendreAltitude($altitude)
    {
        if ($this->getAltitude() > 200 && $this->_trainaterrissagge = FALSE) {
            if ($altitude > $this->_altitudeMax) {
                $this->_altitude = $this->_altitudeMax;
            } elseif ($altitude > 0) {
                $this->_altitude = $this->getAltitude() + $altitude;
            } else {
                $this->_altitude = 0;
            }
        }
    }

    public function perdreAltitude($altitude)
    {
        if ($altitude > $this->_altitudeMax) {
            $this->_altitude = $this->_altitudeMax;
        } elseif ($altitude > 0) {
            $this->_altitude = $this->getAltitude() - $altitude;
        } else {
            $this->_altitude = 0;
        }
    }

    public function decelerer($vitesse)
    {
        if ($this->getVitesse() < 0) {
            $this->setVitesse(0);
        } else {
            $this->setVitesse($this->getVitesse() - $vitesse);
        }
    }

    public function accelerer($vitesse)
    {
        if ($this->getVitesse() < 0) {
            $this->setVitesse(0);
        } else {
            $this->setVitesse($this->getVitesse() + $vitesse);
        }
    }

    public function __toString()
    {
        $chaine = parent::__toString();
        $chaine .= "Altitude Actuelle : " . $this->getAltitude() . "m <br>";
        $chaine .= "AltitudeMax : " . $this->getAltitudeMax() . "m <br><br>";

        $chaine .= "Vitesse Actuelle : " . $this->getVitesse() . "Km/h<br>";
        $chaine .= "VitesseMax : " . $this->getVitesseMax() . "Km/h <br><br>";

        $chaine .= "Train Aterrisage : " . $this->getTrain() . "<br>";
        return $chaine . "<br><br>";
    }
}

$av1 = new Avion(3000, 3000);
$av1->demarrer();

echo $av1;

$av1->accelerer(150);
$av1->decoller();
echo $av1;


$av1->perdreAltitude(40);
$av1->atterrir();
echo $av1;

echo $av1;
// $av1->prendreAltitude(11);
// $av1->setVitesse(10);
// $av1->unsetTrain();
// echo $av1;

?>