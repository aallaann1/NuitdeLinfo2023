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
                        "idArbre" => $idArbre,
                        "login" => $idUtilisateur
                    ];

                    $newPanier = Panier::construireDepuisTableau($values);
                    (new PanierRepository())->sauvegarder($newPanier);

                    MessageFlash::ajouter('success', 'Arbre ajouté au panier');
                    $url = "?action=afficherListe&controleur=arbre";
                    ControleurPanier::redirectionVersURL($url);
                } catch (\Exception $e) {
                    MessageFlash::ajouter('danger', 'Arbre déjà dans le panier');
                    $url = "?action=afficherListe&controleur=arbre";
                    ControleurPanier::redirectionVersURL($url);
                }
            }
        } else {

            $session->enregistrer('panier', [$idArbre => $idArbre]);


            if ($session->contient('listeArbres')) {
                $listeArbresEnSession = $session->lire('listeArbres');

                if (!in_array($idArbre, $session->lire('listeArbres'))) {
                    $listeArbresEnSession[] = $idArbre;
                    $_SESSION['listeArbres'] = $listeArbresEnSession;
                    MessageFlash::ajouter('success', 'Arbre ajouté au panier');
                    $url = "?action=afficherListe&controleur=arbre";
                    ControleurPanier::redirectionVersURL($url);
                } else {
                    MessageFlash::ajouter('danger', 'Arbre déjà dans le panier');
                    $url = "?action=afficherListe&controleur=arbre";
                    ControleurPanier::redirectionVersURL($url);
                }
            } else {
                $session->enregistrer('listeArbres', [$idArbre]);
            }


        }
    }


    public static function supprimer(): void
    {
        $session = Session::getInstance();

        $idArbre = $_GET['idArbre'];

        if (ConnexionUtilisateur::estConnecte()) {
            $idUtilisateur = $_SESSION['utilisateur'];
            (new PanierRepository())->supprimerPanier($idArbre, $idUtilisateur);
            MessageFlash::ajouter('success', 'Chaussure supprimé du panier');
            $url = "?action=afficherPanier&controleur=panier";
            ControleurPanier::redirectionVersURL($url);
        } else {
            unset($_SESSION['listeArbres'][array_search($idArbre, $_SESSION['listeArbres'])]);
            MessageFlash::ajouter('success', 'Arbre supprimé du panier');
            $url = "?action=afficherPanier&controleur=panier";
            ControleurPanier::redirectionVersURL($url);
        }

    }

    public static function validerPanier(){
        if (ConnexionUtilisateur::estConnecte()){


            $idUtilisateur = $_SESSION['utilisateur'];
            $paniers = (new PanierRepository())->recupererParClePrimaireArray($idUtilisateur);

            $arbres = [];

            foreach ($paniers as $panier) {
                $idArbre = $panier->getIdArbre();

                if (!is_null($idArbre)) {
                    $arrayIdArbre[] = $idArbre;
                }
            }

            CommandeRepository::validerPanier($arrayIdArbre, $idUtilisateur);

            foreach ($paniers as $panier) {
                    $idArbre = $panier->getIdArbre();

                    if (!is_null($idArbre)) {
                        (new PanierRepository())->supprimerPanier($idArbre, $idUtilisateur);
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