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
            $ligne['nomcommun'],
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

}