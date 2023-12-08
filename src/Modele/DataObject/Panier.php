<?php

namespace App\Modele\DataObject;

use App\Modele\Model;
use App\Modele\Repository\ConnexionBaseDeDonnee;
use PDO;
use PDOException;


class Panier extends AbstractDataObject
{

    private int $idArbre;
    private string $login;

    public function __construct(int $idChaussure, string $login)
    {
        $this->idChaussure = $idChaussure;
        $this->login = $login;
    }

    public static function construireDepuisTableau(array $panierTableau) : Panier {
        return new Panier(
            $panierTableau["idChaussure"],
            $panierTableau["login"]
        );
    }

    public function getIdChaussure(): int
    {
        return $this->idChaussure;
    }


    public function getChaussure(): Chaussure
    {
        return Chaussure::getChaussure($this->idChaussure);
    }


    public function formatTableau(): array
    {
        return [
            "idChaussure" => $this->idChaussure,
            "login" => $this->login
        ];
    }

}