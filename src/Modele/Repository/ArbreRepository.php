<?php

namespace App\Modele\Repository;

use App\Lib\MessageFlash;
use App\Modele\DataObject\AbstractDataObject;
use App\Modele\DataObject\Arbre;
use App\Modele\DataObject\Commande;
use App\Modele\Repository\ConnexionBaseDeDonnee;
use PDO;
use PDOException;

class ArbreRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'arbre';
    }

    protected function construireDepuisTableau(array $ligne): Arbre
    {
        return new Arbre(
            $ligne['idArbre'],
            $ligne['nomScientifique'],
            $ligne['nomCommun'],
            $ligne['image'],
            $ligne['description']
        );
    }


    protected function getNomClePrimaire(): string
    {
        return 'idArbre';
    }

    protected function getNomsColonnes(): array
    {
        return ['idArbre','nomScientifique', 'nomCommun', 'image', 'description'];
    }

    public function créer(string $nomScientifique, string $nomCommun, string $image, string $description): void
    {
        $sql = "INSERT INTO arbre (nomScientifique, nomCommun, image, description) VALUES (:nomScientifique, :nomCommun, :image, :description)";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $array = [
            "nomScientifique" => $nomScientifique,
            "nomCommun" => $nomCommun,
            "image" => $image,
            "description" => $description
        ];

        try {
            $pdoStatement->execute($array);
        } catch (PDOException $e) {
            MessageFlash::ajouter('error', 'Erreur lors de l\'insertion dans la table arbre.');
            error_log($e->getMessage());
        }
    }

}