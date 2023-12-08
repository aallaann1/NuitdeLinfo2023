<?php

namespace App\Controller;

use App\Controller\ControleurArbre;
use App\Lib\ConnexionUtilisateur;
use App\Lib\MessageFlash;

class ControleurCommande extends ControleurGenerique
{

    public static function afficherGestionCommande(){
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit d'accés");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "gestion des commandes", "cheminVueBody" => "gestionCommande.php"]);
        }
    }

    public static function afficherCommandes(){
        if (!ConnexionUtilisateur::estConnecte()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit d'accés");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "mes commandes", "cheminVueBody" => "commande/mesCommandes.php"]);
        }
    }


}