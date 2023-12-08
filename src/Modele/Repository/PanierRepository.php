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
        $idArbre = $ligne['idArbre'];
        $login = $ligne['login'];

        return new Panier($idArbre, $login);
    }


    protected function getNomClePrimaire(): string
    {
        return 'login';
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idArbre",
            "login"
        ];
    }

    public function supprimerPanier($idArbre, $login){
        $sql = "DELETE FROM panier WHERE login= :login and idArbre= :$*idArbre";
        $array = [
            "login" => $login,
            "idArbre" => $idArbre
        ];
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($array);
    }

}