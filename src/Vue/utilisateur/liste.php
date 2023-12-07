<div class="formulaire">
    <div class="afficherListe">
<ul>
<?php

use App\Modele\DataObject\Utilisateur;
/** @var array $utilisateurs */
/** @var Utilisateur $utilisateur */


foreach ($utilisateurs as $utilisateur) {
    $loginHTML=htmlspecialchars($utilisateur->getLogin());
    $estAdmin=htmlspecialchars($utilisateur->getEstAdmin());
    $loginURL=urldecode($utilisateur->getLogin());
    $lienAfficherDetail="?action=afficherDetail&controleur=utilisateur&login=$loginURL";
    $lienModifier="?action=afficherFormulaireMAJ&controleur=utilisateur&login=$loginURL";
    $lienSupprimer="?action=supprimer&controleur=utilisateur&login=$loginURL";
    echo"<li>";
    if ($estAdmin==1){
        echo"Administrateur de login : $loginHTML";
    }else{
        echo"Utilisateur de login : $loginHTML";
    }

    echo "<div class='horizontal'>";
    echo "<a href=$lienAfficherDetail><p>Detail</p></a>";
    echo "<a href=$lienModifier><p>Modifier</p></a>";
    echo "<a href=$lienSupprimer><p>Supprimer</p></a>";
    echo"</div>";


}
echo"</ul>";
echo "</div>";
echo"</div>";