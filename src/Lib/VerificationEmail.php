<?php

namespace App\Lib;

use App\Configuration\ConfigurationSite;
use App\Modele\DataObject\Utilisateur;
use App\Modele\Repository\UtilisateurRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getLogin());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $URLAbsolue = ConfigurationSite::getURLAbsolue();
        $lienValidationEmail = "$URLAbsolue?action=validerEmail&controleur=utilisateur&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation</a>";


        mail($utilisateur->getEmailAValider(), 'validation Email', $corpsEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
        if ($utilisateur->getNonce() == $nonce){
            $utilisateur->setEmail($utilisateur->getEmailAValider());
            $utilisateur->SetEmailAValider('');
            $utilisateur->SetNonce('');
            (new UtilisateurRepository())->mettreAJour($utilisateur);
            return true;
        }else{
            return false;
        }
    }

    public static function aValideEmail(Utilisateur $utilisateur) : bool
    {
        if (!$utilisateur->getEmail() == ''){
            return true;
        }else{
            return false;
        }
    }
}

