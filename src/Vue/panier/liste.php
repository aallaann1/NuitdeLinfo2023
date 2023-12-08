<div class="formulaire">
<div class="panierContainer">
    <div class="trouver-une-annonce"><h2 class="span">Liste des articles dans votre panier :</h2></div>

<?php

use App\Controller\ControleurPanier;
use App\Modele\Repository\ChaussureRepository;
use App\Lib\ConnexionUtilisateur;
use App\Modele\Repository\PanierRepository;
use App\Modele\DataObject\Panier;

if (ConnexionUtilisateur::estConnecte()) {
    $idUtilisateur = $_SESSION['utilisateur'];

    $paniers[] = (new PanierRepository())->recupererParClePrimaireArray($idUtilisateur);

    if (sizeof($paniers) == 0) {
        echo "<p>Votre panier est vide.</p>";
    }

    $chaussures = [];

    foreach ($paniers as $panierArray) {
        foreach ($panierArray as $panier) {
            $idChaussure = $panier->getIdChaussure();

            if (!is_null($idChaussure)) {
                $chaussures[] = (new ChaussureRepository())->recupererParClePrimaire($idChaussure);
            }
        }
    }


} else if (!ConnexionUtilisateur::estConnecte()) {

    if (isset($_SESSION['panier'])) {
        $listeChaussuresEnSession = isset($_SESSION['listeChaussures']) ? $_SESSION['listeChaussures'] : [];
        $chaussures = [];
        foreach ($listeChaussuresEnSession as $idChaussure) {
            if (!is_null($idChaussure)) {
                $chaussures[] = (new ChaussureRepository())->recupererParClePrimaire($idChaussure);
            }
        }


    } else {
        echo "<p>Votre panier est vide.</p>";
    }


}
?>
<div class="panier">
    <?php if (isset($chaussures) && !empty($chaussures)) : ?>
        <table>
            <thead>
            <tr>
                <th>Nom Chaussure</th>
                <th>Taille</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($chaussures as $chaussure) : ?>
                <tr>
                    <td><?= $chaussure->getNom() ?></td>
                    <td><?= $chaussure->getTaille() ?></td>
                    <td><?= $chaussure->getPrix() ?> €</td>
                    <td>
                        <a href="controleurFrontal.php?action=supprimer&controleur=panier&idChaussure=<?= $chaussure->getIdChaussure() ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php
            $nombresTotal = 0;
            foreach ($chaussures as $chaussure) {
                $nombresTotal += $chaussure->getPrix();
            }
            ?>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="2"><?= $nombresTotal ?> €</td>
            </tr>
            <tr>
                <td colspan="4"><a href="controleurFrontal.php?action=validerPanier&controleur=panier">Valider</a></td>
            </tr>
            <?php endif; ?>


            </tbody>
        </table>
</div>
</div>
</div>