<?php

namespace App\Modele\Repository;

use App\Lib\MessageFlash;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Commande;
use App\Modele\Repository\ConnexionBaseDeDonnee;
use PDO;
use PDOException;

class CommandeRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'commande';
    }

    protected function construireDepuisTableau(array $ligne): Commande
    {
        $idChaussure = $ligne['idChaussure'];
        $login = $ligne['login'];
        $date = $ligne['date'];

        return new Commande($idChaussure, $login, $date);
    }


    protected function getNomClePrimaire(): string
    {
        return 'date';
    }

    protected function getNomsColonnes(): array
    {
        return [
            "idChaussure",
            "login",
            "date"
        ];
    }

    public static function validerPanier($arrayIdChaussure, $login) {
        $sql = "INSERT INTO commande (idChaussure, login, date) VALUES (:idChaussure, :login, NOW())";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        foreach ($arrayIdChaussure as $idChaussure) {
            $array = [
                "login" => $login,
                "idChaussure" => $idChaussure
            ];

            try {
                $pdoStatement->execute($array);
            } catch (PDOException $e) {
                MessageFlash::ajouter('error', 'Erreur lors de l\'insertion dans la table commande.');
                error_log($e->getMessage());
            }
        }
    }

    public function recupererCommandesGroupedByDate() {
        $tab = [];

        $sql = "SELECT * FROM commande ORDER BY date DESC";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);

        foreach ($pdoStatement as $o){
            $tab[]=$this::construireDepuisTableau($o);
        }
        return $tab;
    }

    public function recupererCommandesGroupedByDateAndLogin($login) {
        $tab = [];

        $sql = "SELECT * FROM commande WHERE login = :login ORDER BY date DESC";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(["login" => $login]);

        foreach ($pdoStatement as $o){
            $tab[]=$this::construireDepuisTableau($o);
        }
        return $tab;
    }

    public function recupererUserAyantCommande() {
        $tab = [];

        $sql = "SELECT DISTINCT login FROM commande";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);

        foreach ($pdoStatement as $o){
            $tab[]=$this::construireDepuisTableau($o);
        }
        return $tab;
    }

}