<?php

namespace App\Controller;

use App\Controller\ControleurGenerique;
use App\Lib\ConnexionUtilisateur;
use App\Lib\MotDePasse;
use App\Modele\DataObject\Panier;
use App\Modele\HTTP\Session;
use App\Modele\Repository\ChaussureRepository;
use App\Modele\Repository\CommandeRepository;
use App\Modele\Repository\PanierRepository;
use App\Lib\MessageFlash;

class ControleurPanier extends ControleurGenerique
{

    public static function afficherPanier()
    {
        ControleurPanier::afficherVue('vueGenerale.php', ["pagetitle" => "Panier", "cheminVueBody" => "panier/liste.php"]);
    }

    public static function ajouterAuPanier()
    {
        $session = Session::getInstance();
        $idArbre = $_GET['idArbre'];

        if (ConnexionUtilisateur::estConnecte()) {
            if (isset($_SESSION['utilisateur'])) {
                try {
                    $idUtilisateur = $_SESSION['utilisateur'];
                    $values = [
                        "idChaussure" => $idArbre,
                        "login" => $idUtilisateur
                    ];

                    $newPanier = Panier::construireDepuisTableau($values);
                    (new PanierRepository())->sauvegarder($newPanier);

                    MessageFlash::ajouter('success', 'Arbre ajouté au panier');
                    $url = "?action=afficherListe&controleur=chaussure";
                    ControleurPanier::redirectionVersURL($url);
                } catch (\Exception $e) {
                    MessageFlash::ajouter('danger', 'Arbre déjà dans le panier');
                    $url = "?action=afficherListe&controleur=chaussure";
                    ControleurPanier::redirectionVersURL($url);
                }
            }
        } else {

            $session->enregistrer('panier', [$idArbre => $idArbre]);


            if ($session->contient('listeChaussures')) {
                $listeChaussuresEnSession = $session->lire('listeChaussures');

                if (!in_array($idArbre, $session->lire('listeChaussures'))) {
                    $listeChaussuresEnSession[] = $idArbre;
                    $_SESSION['listeChaussures'] = $listeChaussuresEnSession;
                    MessageFlash::ajouter('success', 'Chaussure ajouté au panier');
                    $url = "?action=afficherListe&controleur=chaussure";
                    ControleurPanier::redirectionVersURL($url);
                } else {
                    MessageFlash::ajouter('danger', 'Chaussure déjà dans le panier');
                    $url = "?action=afficherListe&controleur=chaussure";
                    ControleurPanier::redirectionVersURL($url);
                }
            } else {
                $session->enregistrer('listeChaussures', [$idChaussure]);
            }


        }
    }


    public static function supprimer(): void
    {
        $session = Session::getInstance();

        $idChaussure = $_GET['idChaussure'];

        if (ConnexionUtilisateur::estConnecte()) {
            $idUtilisateur = $_SESSION['utilisateur'];
            (new PanierRepository())->supprimerPanier($idChaussure, $idUtilisateur);
            MessageFlash::ajouter('success', 'Chaussure supprimé du panier');
            $url = "?action=afficherPanier&controleur=panier";
            ControleurPanier::redirectionVersURL($url);
        } else {
            unset($_SESSION['listeChaussures'][array_search($idChaussure, $_SESSION['listeChaussures'])]);
            MessageFlash::ajouter('success', 'Chaussure supprimé du panier');
            $url = "?action=afficherPanier&controleur=panier";
            ControleurPanier::redirectionVersURL($url);
        }

    }

    public static function validerPanier(){
        if (ConnexionUtilisateur::estConnecte()){


            $idUtilisateur = $_SESSION['utilisateur'];
            $paniers[] = (new PanierRepository())->recupererParClePrimaireArray($idUtilisateur);

            $chaussures = [];

            foreach ($paniers as $panierArray) {
                foreach ($panierArray as $panier) {
                    $idChaussure = $panier->getIdChaussure();

                    if (!is_null($idChaussure)) {
                        $chaussures[] = $idChaussure;
                    }
                }
            }

            CommandeRepository::validerPanier($chaussures, $idUtilisateur);

            foreach ($paniers as $panierArray) {
                foreach ($panierArray as $panier) {
                    $idChaussure = $panier->getIdChaussure();

                    if (!is_null($idChaussure)) {
                        (new PanierRepository())->supprimerPanier($idChaussure, $idUtilisateur);
                    }
                }
            }

            MessageFlash::ajouter('success', 'Votre panier a été validé');
            $url = "?action=afficherPanier&controleur=panier";
            ControleurPanier::redirectionVersURL($url);
        } else {
            MessageFlash::ajouter('danger', 'Vous devez être connecté pour valider votre panier');
            $url = "?action=afficherPanier&controleur=panier";
            ControleurPanier::redirectionVersURL($url);
        }
    }


}