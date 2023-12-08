<?php

namespace App\Controller;

use App\Lib\ConnexionUtilisateur;
use App\Lib\MessageFlash;
use App\Modele\DataObject\Arbre;
use App\Modele\Repository\ArbreRepository;

class ControleurArbre extends ControleurGenerique
{

    public static function afficherListe(): void
    {
        $arbres = (new ArbreRepository())->recuperer();
        if (sizeof($arbres) == 0) {
            $messageErreur = "Il y a aucun arbre dans la BD";
            ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "arbre/erreur.php", "messageErreur" => $messageErreur]);
        } else {
            $pagetitle = "Liste des arbres";
            ControleurArbre::afficherVue('vueGenerale.php', ["arbres" => $arbres, "pagetitle" => $pagetitle, "cheminVueBody" => "arbre/liste.php"]);
        }
    }


    public static function afficherDetail(): void
    {
        $idArbre = $_REQUEST['idArbre'];
        $arbre = (new ArbreRepository())->recupererParClePrimaire($idArbre);
        if ($arbre == null) {
            $messageErreur = "Il y a aucun arbre dans la BD";
            ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "arbre/erreur.php", "messageErreur" => $messageErreur]);
        } else {
            $pagetitle = "Detail de l'arbre";
            ControleurArbre::afficherVue('vueGenerale.php', ["arbre" => $arbre, "pagetitle" => $pagetitle, "cheminVueBody" => "arbre/detail.php"]);
        }
    }

    public static function supprimer(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour supprimer un arbre");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            $idArbre = $_REQUEST['idArbre'];
            $arbre = (new ArbreRepository())->recupererParClePrimaire($idArbre);
            if ($arbre == null) {
                $messageErreur = "Il y a aucun arbre dans la BD";
                ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "arbre/erreur.php", "messageErreur" => $messageErreur]);
            } else {
                (new ArbreRepository())->supprimer($arbre);
                MessageFlash::ajouter('info', "arbre supprimé");
                $url = "?action=afficherListe&controleur=arbre";
                ControleurArbre::redirectionVersURL($url);
            }
        }
    }

    public static function afficherFormulaireCreation(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour creer un arbre");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "formulaireCreation", "cheminVueBody" => "arbre/formulaireCreation.php"]);
        }
    }

    public static function creerDepuisFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour creer un arbre");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            $arbre = new Arbre(null, $_REQUEST['nomScientifique'], $_REQUEST['nomCommun'], $_REQUEST['image'], $_REQUEST['description']);
            (new ArbreRepository())->creer($arbre);
            MessageFlash::ajouter('info', "arbre créé");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        }
    }

    public static function afficherFormulaireMiseAJour(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour modifier un arbre");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            $idArbre = $_REQUEST['idArbre'];
            $arbre = (new ArbreRepository())->recupererParClePrimaire($idArbre);
            if ($arbre == null) {
                $messageErreur = "Il y a aucun arbre dans la BD";
                ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "arbre/erreur.php", "messageErreur" => $messageErreur]);
            } else {
                ControleurArbre::afficherVue('vueGenerale.php', ["arbre" => $arbre, "pagetitle" => "formulaireMiseAJour", "cheminVueBody" => "arbre/formulaireMiseAJour.php"]);
            }
        }
    }


    public static function mettreAJour(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour modifier un arbre");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurArbre::redirectionVersURL($url);
        } else {
            $idArbre = $_REQUEST['idArbre'];
            $arbre = (new ArbreRepository())->recupererParClePrimaire($idArbre);
            if ($arbre == null) {
                $messageErreur = "Il y a aucun arbre dans la BD";
                ControleurArbre::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "arbre/erreur.php", "messageErreur" => $messageErreur]);
            } else {
                $arbre->setNomScientifique($_REQUEST['nomScientifique']);
                $arbre->setNomcommun($_REQUEST['nomCommun']);
                $arbre->setImage($_REQUEST['image']);
                $arbre->setDescription($_REQUEST['description']);
                (new ArbreRepository())->mettreAJour($arbre);
                MessageFlash::ajouter('info', "arbre mis à jour");
                $url = "?action=afficherListe&controleur=arbre";
                ControleurArbre::redirectionVersURL($url);
            }
        }
    }


}
