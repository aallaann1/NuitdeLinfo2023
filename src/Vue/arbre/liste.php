<div class="formulaire">
    <div class="panierContainer">
        <?php

        use App\Controller\ControleurPanier;
        use App\Modele\Repository\ArbreRepository;
        use App\Modele\DataObject\Arbre;
        use App\Lib\ConnexionUtilisateur;
        use App\Modele\Repository\PanierRepository;
        use App\Modele\DataObject\Panier;


            $arbres = (new ArbreRepository())->recuperer();

            if (sizeof($arbres) == 0) {
                echo "<p>Votre BDD est vide.</p>";
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
                            <a href="controleurFrontal.php?action=ajouterAuPanier&controleur=panier&idChaussure=<?= $arbre->getIdArbre() ?>">Ajout au panier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

