<?php

namespace App\Modele\DataObject;

use App\Modele\Model;
use App\Modele\Repository\ConnexionBaseDeDonnee;
use PDO;
use PDOException;


class Commande extends AbstractDataObject
{

    private $idChaussure;
    private $login;

    private $date;

    public function __construct($idChaussure, $login, $date)
    {
        $this->idChaussure = $idChaussure;
        $this->login = $login;
        $this->date = $date;
    }

    public static function construireDepuisTableau(array $panierTableau) : Commande {
        return new Commande(
            $panierTableau["idChaussure"],
            $panierTableau["login"],
            $panierTableau["date"]
        );
    }

    public function getIdChaussure(): int
    {
        return $this->idChaussure;
    }


    public function getChaussure(): Arbre
    {
        return Arbre::get($this->idChaussure);
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getDate(): string
    {
        return $this->date;
    }


    public function formatTableau(): array
    {
        return [
            "idChaussure" => $this->idChaussure,
            "login" => $this->login,
            "date" => $this->date
        ];
    }

}