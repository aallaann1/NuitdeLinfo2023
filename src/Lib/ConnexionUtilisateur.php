<?php

namespace App\Lib;

use App\Modele\HTTP\Session;
use App\Modele\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        ConnexionUtilisateur::$cleConnexion = $loginUtilisateur;
        $session = Session::getInstance();
        $session->enregistrer('cleConnexion', ConnexionUtilisateur::$cleConnexion);
    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient('cleConnexion');

    }

    public static function  deconnecter(): void
    {
        $session = Session::getInstance();
        $session->supprimer('cleConnexion');
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        $session = Session::getInstance();
        return $session->lire('cleConnexion');
    }

    public static function estUtilisateur($login): bool
    {

        if (ConnexionUtilisateur::getLoginUtilisateurConnecte() == $login) {
            return true;
        } else {
            return false;
        }
    }

    public static function estAdministrateur(): bool
    {
        if (ConnexionUtilisateur::estConnecte()) {
                $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            if ($utilisateur->getEstAdmin()) {
                return true;
            }
        }
        return false;


    }


}

