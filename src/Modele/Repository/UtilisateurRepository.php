<?php

namespace App\Modele\Repository;

use App\Modele\DataObject\Utilisateur;
use PDO;
use PDOException;

class UtilisateurRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'utilisateur';
    }


    /**
     * @param array $utilisateurTableau
     * @return Utilisateur
     */
    protected function construireDepuisTableau(array $ligne): Utilisateur
    {
        $login = $ligne['login'];
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        $mdpHache = $ligne['mdpHache'];
        $estAdmin = $ligne['estAdmin'];
        $email = $ligne['email'];
        $emailAValider = $ligne['emailAValider'];
        $nonce = $ligne['nonce'];

        return new Utilisateur($login, $nom, $prenom, $mdpHache,$estAdmin,$email,$emailAValider,$nonce);
    }

    protected function getNomsColonnes(): array
    {
        return ['login', 'nom', 'prenom', 'mdpHache', 'estAdmin', 'email', 'emailAValider', 'nonce'];
    }

    protected function getNomClePrimaire(): string
    {
        return 'login';
    }



}