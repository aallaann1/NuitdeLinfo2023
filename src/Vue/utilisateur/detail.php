<div class="formulaire">
<div class="detail">
<?php

use App\Modele\Repository\UtilisateurRepository;
use App\Lib\ConnexionUtilisateur;

/** @var TYPE_NAME $utilisateur */

$utilisateur = (new UtilisateurRepository())->recupererParClePrimaire($_GET['login']);
$loginURL=rawurldecode($utilisateur->getLogin());
$lienModifier = "?action=afficherFormulaireMAJ&controleur=utilisateur&login=$loginURL";

echo "<div class='trouver-une-annonce'><div class='span'><h1>Votre compte :</h1></div></div>";
echo "<p>Login : " . htmlspecialchars($utilisateur->getLogin()) . "</p>";
echo "<p>Nom : " . htmlspecialchars($utilisateur->getNom()) . "</p>";
echo "<p>Prenom : " . htmlspecialchars($utilisateur->getPrenom()) . "</p>";
echo "<p>Email :" . htmlspecialchars($utilisateur->getEmailAValider()) . "</p>";
if (ConnexionUtilisateur::estAdministrateur()){
    if ($utilisateur->getEstAdmin()){
        echo"admin";
    }else{
        echo"utilisateur simple";
    }
}
echo"<a href='$lienModifier'><p>Modifier</p></a>";
echo"</div>";
echo"</div>";