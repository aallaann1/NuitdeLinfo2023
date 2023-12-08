<div class="formulaire">
<div class="panierContainer">
    <div class="trouver-une-annonce"><h2 class="span">Liste des articles dans votre panier :</h2></div>

<?php

use App\Controller\ControleurPanier;
use App\Modele\Repository\ArbreRepository;
use App\Lib\ConnexionUtilisateur;
use App\Modele\Repository\PanierRepository;
use App\Modele\DataObject\Panier;

if (ConnexionUtilisateur::estConnecte()) {
    $idUtilisateur = $_SESSION['utilisateur'];

    $paniers = (new PanierRepository())->recupererParClePrimaireArray($idUtilisateur);

    if (sizeof($paniers) == 0) {
        echo "<p>Votre panier est vide.</p>";
    }

    $arbres = [];

    foreach ($paniers as $panierArray) {
            $idArbre = $panierArray->getIdArbre();

            if (!is_null($idArbre)) {
                $arbres[] = (new ArbreRepository())->recupererParClePrimaire($idArbre);
        }
    }


} else if (!ConnexionUtilisateur::estConnecte()) {

    if (isset($_SESSION['panier'])) {
        $listeArbresEnSession = isset($_SESSION['listeArbres']) ? $_SESSION['listeArbres'] : [];
        $arbres = [];
        foreach ($listeArbresEnSession as $idArbre) {
            if (!is_null($idArbre)) {
                $arbres[] = (new ArbreRepository())->recupererParClePrimaire($idArbre);
            }
        }


    } else {
        echo "<p>Votre panier est vide.</p>";
    }


}
?>
<div class="panier">
    <?php if (isset($arbres) && !empty($arbres)) : ?>
    <table>
        <thead>
        <tr>
            <th>Photo</th>
            <th>Nom arbre</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($arbres as $arbre) : ?>
            <tr>
                <td><img src="<?= $arbre->getImage() ?>" alt="Arbre Image" width=50px height=50px></td>
                <td><?= $arbre->getNomCommun() ?></td>
                <td><?= $arbre->getDescription() ?></td>
                <td>
                    <a href="controleurFrontal.php?action=supprimer&controleur=panier&idArbre=<?= $arbre->getIdArbre() ?>">supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="4"><a href="controleurFrontal.php?action=validerPanier&controleur=panier">Valider</a></td>
            </tr>
            <?php endif; ?>


            </tbody>
        </table>
</div>
</div>
</div>