<?php

namespace App\Controller;

use App\Lib\MessageFlash;
use App\Lib\VerificationEmail;
use App\Lib\ConnexionUtilisateur;
use App\Lib\MotDePasse;
use App\Modele\DataObject\Utilisateur;
use App\Modele\Repository\UtilisateurRepository;

class ControleurUtilisateur extends ControleurGenerique
{


    public static function afficherDetail(): void
    {
        if (!isset($_REQUEST['login'])) {
            MessageFlash::ajouter('warning', "Impossible d'afficher les détail d'un utilisateur si l'on précise pas son login");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_REQUEST['login']);
            if (is_null($utilisateur)) {
                MessageFlash::ajouter('warning', "il n'existe pas d'utilisateur ayant le login : " . $_REQUEST['login']);
                $url = "?action=afficherListe&controleur=chaussure";
                ControleurChaussure::redirectionVersURL($url);
            } else {
                ControleurUtilisateur::afficherVue('vueGenerale.php', ["pagetitle" => "afficherDetail", "cheminVueBody" => "utilisateur/detail.php", "utilisateur" => $utilisateur]);
            }
        }
    }


    public static function afficherListe(): void
    {
        $utilisateurs = (new UtilisateurRepository)->recuperer();

        if (sizeof($utilisateurs) == 0) {
            ControleurUtilisateur::afficherErreur("pas d'utilisateurs dans la bd");
        } else {
            ControleurUtilisateur::afficherVue('vueGenerale.php', ["pagetitle" => "afficherListe", "cheminVueBody" => "utilisateur/liste.php", "utilisateurs" => $utilisateurs]);
        }
    }

    public static function afficherFormulaireConnexion(): void
    {
        ControleurUtilisateur::afficherVue('vueGenerale.php', ["pagetitle" => "Inscription", "cheminVueBody" => "utilisateur/formulaireConnexion.php"]);
    }

    public static function afficherFormulaireInscription(): void
    {
        ControleurUtilisateur::afficherVue('vueGenerale.php', ["pagetitle" => "Inscription", "cheminVueBody" => "utilisateur/formulaireInscription.php"]);
    }

    public static function afficherFormulaireMAJ(): void
    {
        $login=$_REQUEST['login'];
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);
        if (is_null($utilisateur)) {
            MessageFlash::ajouter('warning', "l'utilisateur avec le login: " . $login . " n'existe pas.");
            $url = "?action=afficherListe&controleur=chaussure";
            ControleurChaussure::redirectionVersURL($url);
        } else {
            if (ConnexionUtilisateur::estUtilisateur($_REQUEST["login"]) || ConnexionUtilisateur::estAdministrateur()) {
                ControleurUtilisateur::afficherVue('vueGenerale.php', ["pagetitle" => "formulaireMAJ", "cheminVueBody" => "utilisateur/formulaireMiseAJour.php", "login" => $login, "utilisateur" => $utilisateur]);
            } else {
                MessageFlash::ajouter('danger', "L'accès au formulaire est réservé aux utilisateurs connectés.");
                $url = "?action=afficherListe&controleur=chaussure";
                ControleurChaussure::redirectionVersURL($url);
            }
        }
    }

    public static function creerUtilisateur(): void
    {
        $login = $_REQUEST['login'];
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $mdp = $_REQUEST['mdp'];
        $mdp2 = $_REQUEST['mdp2'];
        $email = $_REQUEST['email'];
        if (isset($_REQUEST['estAdmin']) && ConnexionUtilisateur::estAdministrateur()) {
            $estAdmin = 1;
        } else {
            $estAdmin = 0;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($mdp == $mdp2) {
                $values = array(
                    "login" => $login,
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "mdp" => $mdp,
                    "estAdmin" => $estAdmin,
                    "email" => $email,
                );

                $newUtilisateur = Utilisateur::construireDepuisFormulaire($values);
                (new UtilisateurRepository())->sauvegarder($newUtilisateur);


                MessageFlash::ajouter('danger', "Utilisateur inscrit");
                $url = "?action=afficherListe&controleur=arbre";
                ControleurUtilisateur::redirectionVersURL($url);

            } else {
                ControleurUtilisateur::afficherErreur("mot de passe distinct");
            }
        } else {
            ControleurUtilisateur::afficherErreur("email non valide");
        }
    }

    public static function mettreAJour()
    {
        $login = $_REQUEST['login'];
        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $email = $_REQUEST['email'];

        if (!isset($_REQUEST['Amdp'])) {
            $Amdp = '';
        } else {
            $Amdp = $_REQUEST['Amdp'];
        }


        if (strlen($_REQUEST['mdp'])>1){
            $mdp = $_REQUEST['mdp'];
            $mdp2 = $_REQUEST['mdp2'];
        }else{
            $mdp = $Amdp;
            $mdp2 = $Amdp;
        }

        if (isset($_REQUEST['estAdmin']) && ConnexionUtilisateur::estAdministrateur()) {
            $admin = 1;
        } else {
            $admin = 0;
        }

        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);



        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (isset($login) && isset($nom) && isset($prenom)) {

                if (!is_null($utilisateur)) {
                    if (ConnexionUtilisateur::estUtilisateur($login) || ConnexionUtilisateur::estAdministrateur()) {
                        if (MotDePasse::verifier($Amdp, $utilisateur->getMdpHache()) || ConnexionUtilisateur::estAdministrateur()) {
                            if ($mdp == $mdp2) {
                                $values = array(
                                    "login" => $login,
                                    "nom" => $nom,
                                    "prenom" => $prenom,
                                    "mdp" => $mdp,
                                    "estAdmin" => $admin,
                                    "email" => $email,
                                );

                                $ModifUtilisateur = Utilisateur::construireDepuisFormulaire($values);

                                (new UtilisateurRepository())->mettreAJour($ModifUtilisateur);

                                MessageFlash::ajouter('success', "utilisateur mis a jour");
                                $url = "?action=afficherListe&controleur=arbre";
                                ControleurUtilisateur::redirectionVersURL($url);

                            } else {
                                MessageFlash::ajouter('warning', "Mots de passe distincts");
                                $url = "?action=afficherListe&controleur=arbre";
                                ControleurUtilisateur::redirectionVersURL($url);
                            }
                        } else {
                            MessageFlash::ajouter('warning', "Ancien mot de passe erroné");
                            $url = "?action=afficherListe&controleur=arbre";
                            ControleurUtilisateur::redirectionVersURL($url);
                        }
                    } else {
                        MessageFlash::ajouter('warning', "La mise à jour n’est possible que pour l’utilisateur connecté");
                        $url = "?action=afficherListe&controleur=arbre";
                        ControleurUtilisateur::redirectionVersURL($url);
                    }
                } else {
                    MessageFlash::ajouter('warning', "l'utilisateur avec ce login n'existe pas.");
                    $url = "?action=afficherListe&controleur=arbre";
                    ControleurUtilisateur::redirectionVersURL($url);
                }
            } else {
                MessageFlash::ajouter('warning', "veuillez completer tous les champs du formulaire.");
                $url = "?action=afficherListe&controleur=arbre";
                ControleurUtilisateur::redirectionVersURL($url);
            }
        } else {
            MessageFlash::ajouter('warning', "email non valide.");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurUtilisateur::redirectionVersURL($url);
        }


    }

    public static function connecter()
    {
        session_start();
        if (isset($_REQUEST['login']) && isset($_REQUEST['mdp'])) {
            $login = $_REQUEST['login'];
            $mdp = $_REQUEST['mdp'];
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($login);

            if (!is_null($utilisateur) && MotDePasse::verifier($mdp, $utilisateur->getMdpHache())) {
                    $_SESSION['utilisateur'] = $login;
                    ConnexionUtilisateur::connecter($login);

                MessageFlash::ajouter('warning', "Utilisateur connecté");
                $url = "?action=afficherListe&controleur=arbre";
                    ControleurUtilisateur::redirectionVersURL($url);

            } else {
                MessageFlash::ajouter('warning', "l'utilisateur " . $login . " n'existe pas ou le mot de passe n'est pas correct");
                $url = "?action=afficherListe&controleur=arbre";
                ControleurUtilisateur::redirectionVersURL($url);
            }

        } else {
            MessageFlash::ajouter('warning', "login ou mdp non renseigner");
            $url = "?action=afficherListe&controleur=arbre";
            ControleurUtilisateur::redirectionVersURL($url);
        }

    }

    public static function deconnecter(): void
    {
        session_start();
        unset($_SESSION['utilisateur']);
        ConnexionUtilisateur::deconnecter();
        MessageFlash::ajouter('info', "Utilisateur déconnecté");
        $url = "?action=afficherListe&controleur=arbre";
        ControleurUtilisateur::redirectionVersURL($url);
    }

    public static function validerEmail()
    {
        if (isset($_REQUEST['login']) && isset($_REQUEST['nonce'])) {
            $login = $_REQUEST['login'];
            $nonce = $_REQUEST['nonce'];

            if (VerificationEmail::traiterEmailValidation($login, $nonce)) {

                MessageFlash::ajouter("info", "email valider");
                $url = "?action=afficherListe&controleur=utilisateur";
                ControleurUtilisateur::redirectionVersURL($url);

            } else {
                MessageFlash::ajouter("warning", "Ce n'est pas la bonne adresse email.");
                $url = "?action=afficherListe&controleur=utilisateur";
                ControleurUtilisateur::redirectionVersURL($url);
            }

        } else {
            MessageFlash::ajouter("warning", "Le login ou le nonce n'est pas initialisé.");
            $url = "?action=afficherListe&controleur=utilisateur";
            ControleurUtilisateur::redirectionVersURL($url);
        }
    }


    public static function supprimer()

    {
        $login = $_REQUEST['login'];

        if (ConnexionUtilisateur::estUtilisateur($login) || ConnexionUtilisateur::estAdministrateur()) {
            (new UtilisateurRepository())->supprimer($login);

            MessageFlash::ajouter("info", "Utilisateur supprimé");
            $url = "?action=afficherListe&controleur=utilisateur";
            ControleurUtilisateur::redirectionVersURL($url);
        } else {
            MessageFlash::ajouter("warning", "La mise à jour n’est possible que pour l’utilisateur connecté.");
            $url = "?action=afficherListe&controleur=utilisateur";
            ControleurUtilisateur::redirectionVersURL($url);
        }
    }


}