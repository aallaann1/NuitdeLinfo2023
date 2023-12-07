<?php

namespace App\Modele\Repository;

use App\Lib\MessageFlash;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Panier;
use PDO;
use PDOException;
use App\Modele\Repository\ConnexionBaseDeDonnee;

class PanierRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'panier';
    }

    protected function construireDepuisTableau(array $ligne): Panier
    {
        $idChaussure = $ligne['idChaussure'];
        $login = $ligne['login'];

        return new Panier($idChaussure, $login);
    }


    protected function getNomClePrimaire(): string
    {
        return 'login';
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idChaussure",
            "login"
        ];
    }

    public function supprimerPanier($idChaussure, $login){
        $sql = "DELETE FROM panier WHERE login= :login and idChaussure= :idChaussure";
        $array = [
            "login" => $login,
            "idChaussure" => $idChaussure
        ];
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($array);
    }

}