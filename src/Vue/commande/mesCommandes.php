<div class="formulaire">
    <div class="panierContainer">
        <div class="trouver-une-annonce"><h2 class="span">Liste des commandes :</h2></div>

        <?php
        use App\Modele\Repository\CommandeRepository;

        $idUtilisateur = $_SESSION['utilisateur'];
        $tab[] = (new CommandeRepository())->recupererCommandesGroupedByDateAndLogin($idUtilisateur);


        ?>

        <div class="panier">

            <table>
                <thead>
                <tr>
                    <th>ID Chaussure</th>
                    <th>Login</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php


                foreach ($tab as $commandes) {
                    foreach ($commandes as $commande) {
                        echo "<tr>";
                        echo "<td>" . $commande->getIdChaussure() . "</td>";
                        echo "<td>" . $commande->getLogin() . "</td>";
                        echo "<td>" . $commande->getDate() . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>

        </div>



    </div>
</div>