<?php

namespace App\Controller;

use App\Lib\ConnexionUtilisateur;
use App\Lib\MessageFlash;
use App\Modele\DataObject\Chaussure;
use App\Modele\Repository\ChaussureRepository;

class ControleurChaussure extends ControleurGenerique
{

    public static function afficherListe(): void
    {
        $chaussures = (new ChaussureRepository())->recuperer();
        if (sizeof($chaussures) == 0) {
            $messageErreur = "Il y a aucune chaussure dans la BD";
            ControleurChaussure::afficherVue('vueGenerale.php', ["pagetitle" => "Erreur", "cheminVueBody" => "chaussure/erreur.php", "messageErreur" => $messageErreur]);
        } else {
            $pagetitle = "Liste des chaussures";
            ControleurChaussure::afficherVue('vueGenerale.php', ["chaussures" => $chaussures, "pagetitle" => $pagetitle, "cheminVueBody" => "chaussure/liste.php"]);
        }
    }


    public static function afficherDetail(): void
    {
        if (!isset($_REQUEST['idChaussure'])) {
            MessageFlash::ajouter('warning', "Impossible d'afficher détail d'une chaussure s'il n'y a pas d'ID");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {
            $chaussure = (new ChaussureRepository())->recupererParClePrimaire($_REQUEST['idChaussure']);
            if (is_null($chaussure)) {
                MessageFlash::ajouter('warning', "il n'existe pas de chaussure ayant l'id : " . $_REQUEST['idChaussure']);
                $url = "?action=afficherListe&controleur=chaussure";
                ControleurChaussure::redirectionVersURL($url);
            } else {
                ControleurChaussure::afficherVue('vueGenerale.php', ["pagetitle" => "Detail", "cheminVueBody" => "chaussure/detail.php", "chaussure" => $chaussure]);
            }
        }
    }

    public static function supprimer(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()){
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour supprimer une chaussure");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        }else {
            $idChaussure = $_REQUEST['idChaussure'];

            (new chaussureRepository())->supprimer($idChaussure);

            MessageFlash::ajouter('success', 'chaussure supprimer');
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        }
    }

    public static function afficherFormulaireCreation(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour creer une chaussure");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {
            ControleurChaussure::afficherVue('vueGenerale.php', ["pagetitle" => "formulaireCreation", "cheminVueBody" => "chaussure/formulaireCreation.php"]);
        }
    }

    public static function creerDepuisFormulaire(): void
    {
        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour creer une chaussure");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                $photo_tmp = $_FILES['photo']['tmp_name'];

                $photoContent = file_get_contents($photo_tmp);

                $newChaussure = new Chaussure(
                    $_REQUEST['idChaussure'],
                    $photoContent,
                    $_REQUEST['nom'],
                    $_REQUEST['taille'],
                    $_REQUEST['prix'],
                    $_REQUEST['description']
                );

                (new ChaussureRepository())->sauvegarder($newChaussure);

                MessageFlash::ajouter('success', 'Chaussure créée avec succès');
                $url = "?action=afficherListe&controleur=chaussure";
                ControleurChaussure::redirectionVersURL($url);
            } else {
                echo "Erreur lors du téléchargement du fichier.";
            }
        }
    }

    public static function afficherFormulaireMiseAJour(): void
    {
        //todo remettre le if quand on pourra se connecter
        /*if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour modifier une chaussure");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {*/
            $idChaussure = $_REQUEST['idChaussure'];
            $chaussure = (new ChaussureRepository())->recupererParClePrimaire($idChaussure);

            ControleurChaussure::afficherVue('vueGenerale.php', ["pagetitle" => "formulaireMAJ", "cheminVueBody" => "chaussure/formulaireMiseAJour.php", "chaussure" => $chaussure, "idChaussure" => $idChaussure]);
       /* }*/
    }


    public static function mettreAJour(): void
    {
/*        if (!ConnexionUtilisateur::estAdministrateur()) {
            MessageFlash::ajouter('warning', "vous n'avez pas les droit pour modifier une chaussure");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {*/
        //todo remettre quand on pourra se connecter
        if (isset($_REQUEST['nouvellePhoto'])){
            $photo = $_REQUEST['nouvellePhoto'];
        }else{
            $photo = $_REQUEST[''];
        }
            $chaussure = new Chaussure($_REQUEST['idChaussure'], $photo, $_REQUEST['nom'], $_REQUEST['taille'], $_REQUEST['prix'], $_REQUEST['description']);
            (new ChaussureRepository())->mettreAJour($chaussure);

        MessageFlash::ajouter('info', "chaussure mis a jour");
        $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
/*        }*/
    }


}
