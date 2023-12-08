<?php

namespace App\Modele\DataObject;

use App\Modele\Model;
use App\Modele\Repository\ConnexionBaseDeDonnee;
use PDO;
use PDOException;
use App\Modele\Repository\ArbreRepository;
use App\Modele\DataObject\Arbre;


class Panier extends AbstractDataObject
{

    private int $idArbre;
    private string $login;

    public function __construct(int $idArbre, string $login)
    {
        $this->idArbre = $idArbre;
        $this->login = $login;
    }

    public static function construireDepuisTableau(array $panierTableau) : Panier {
        return new Panier(
            $panierTableau["idArbre"],
            $panierTableau["login"]
        );
    }

    public function getIdArbre(): int
    {
        return $this->idArbre;
    }


    public function getArbre(): Arbre
    {
        return Arbre::getArbre($this->idArbre);
    }


    public function formatTableau(): array
    {
        return [
            "idArbre" => $this->idArbre,
            "login" => $this->login
        ];
    }

}