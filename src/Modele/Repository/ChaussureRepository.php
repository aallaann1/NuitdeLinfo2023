<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\Chaussure;
use PDO;
use PDOException;

class chaussureRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'chaussure';
    }


    /**
     * @param array $voitureFormatTableau
     * @return chaussure
     */
    protected function construireDepuisTableau(array $chaussureFormatTableau): Chaussure
    {
        $idChaussure = $chaussureFormatTableau['idChaussure'];
        $photo = $chaussureFormatTableau['photo'];
        $nom = $chaussureFormatTableau['nom'];
        $taille = $chaussureFormatTableau['taille'];
        $prix = $chaussureFormatTableau['prix'];
        $description = $chaussureFormatTableau['description'];

        return new Chaussure($idChaussure, $photo, $nom, $taille, $prix, $description);
    }

    protected function getNomClePrimaire(): string
    {
        return 'idChaussure';
    }


    public function getNomsColonnes(): array
    {
        return [
            "idChaussure",
            "photo",
            "nom",
            "taille",
            "prix",
            "description",
        ];
    }
}