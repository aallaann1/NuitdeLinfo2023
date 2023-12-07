<div class="landing">
    <div class="search">
        <p class="trouver-une-annonce">
            <span class="span">Trouver une </span>
            <span class="text-wrapper-2">godasse</span>
            <span class="span"> à vos pieds </span>
            <span class="span"> !</span>
        </p>
        <div class="search-bar">
            <div class="text-wrapper-3">Rechercher...</div>
            <div class="frame"><img class="tabler-icon-search" src='../../../../../../~cayraca/projetPhp/e-commerce/ressources/img/frame-5' /></div>
        </div>
    </div>
    <div class="annonces">

        <?php

        /** @var  array $chaussures */
        $ligneActuelle = 0;
        $modulo = sizeof($chaussures)%3;
        $nbLigne = intdiv(sizeof($chaussures),3);
        if ($nbLigne>0 && $modulo==0){
            $nbLigne--;
        }
        $colonne = 0;
        $indice = 0;
        $autorise = 2;


        foreach ($chaussures as $chaussure) {


            $nomHtml = htmlspecialchars($chaussure->getNom());
            $descriptionHtml = htmlspecialchars($chaussure->getDescription());
            $image = $chaussure->getPhoto();
            $prixHtml = htmlspecialchars($chaussure->getPrix());
            $link = urldecode("?action=afficherDetail&idChaussure=".$chaussure->getIdChaussure());
            $lienModifier = urldecode("?action=afficherFormulaireMiseAJour&controleur=chaussure&idChaussure=".$chaussure->getIdChaussure());
            $lienSupprimer = urldecode("?action=supprimer&controleur=chaussure&idChaussure=".$chaussure->getIdChaussure());
            $urlDuPanier = urldecode("?action=ajouterAuPanier&controleur=panier&idChaussure=".$chaussure->getIdChaussure());

            if ($modulo==0){
                $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$prixHtml,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
            }else if ($modulo==1){
                if ($indice==$nbLigne){
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$prixHtml,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $nbLigne--;
                }else{
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$prixHtml,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $indice++;
                }
            }else{
                if ($indice==$nbLigne){
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$prixHtml,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $autorise--;
                    if ($autorise==0) {
                        $nbLigne--;
                        $indice++;
                    }else{
                        $indice=0;
                    }
                }else{
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$prixHtml,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $indice++;
                }
            }

        }






        function afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$prixHtml,$link,$lienModifier,$lienSupprimer,$lienPanier) : int
        {
            if ($nbLigne==0){
                echo "<div class='frame-2'>";
                affichageAnnonce($nomHtml,$descriptionHtml,$image,$prixHtml,$link,$lienModifier,$lienSupprimer,$lienPanier);
                echo"</div>";
                return 0;
            }

            else if ($modulo==0){
                if ($ligneActuelle==0){
                    echo "<div class='frame-2'>";
                }

                affichageAnnonce($nomHtml,$descriptionHtml,$image,$prixHtml,$link,$lienModifier,$lienSupprimer,$lienPanier);

                if ($ligneActuelle==$nbLigne){
                    echo"</div>";
                    return 0;
                }
                return $ligneActuelle+1;
            }


            else{
                if ($ligneActuelle==0){
                    echo "<div class='frame-2'>";
                }

                affichageAnnonce($nomHtml,$descriptionHtml,$image,$prixHtml,$link,$lienModifier,$lienSupprimer,$lienPanier);

                if ($ligneActuelle==$nbLigne){
                    echo"</div>";
                    return 0;

                }else{
                    $ligneActuelle++;
                }
                return $ligneActuelle;
            }
        }


        function affichageAnnonce($nomHtml, $descriptionHtml, $image,$prixHtml,$link,$lienModifier,$lienSupprimer,$lienPanier)
        {
            echo "<div class='annonce'>
            <img class='rectangle' src='data:image/jpeg;base64," . base64_encode($image) . "' />
            <div class='frame-3'>
              <div class='frame-4'>
                <div class='title'>
                  <div class='price'><div class='text-wrapper-4'>$prixHtml $</div></div>
                  <div class='porsche'>$nomHtml</div>";

            if (\App\Lib\ConnexionUtilisateur::estAdministrateur()){
                echo"<a href=$lienModifier><p>modifier</p></a> <a href=$lienSupprimer><p> supprimer</p></a>";
            }

            echo"</div>
                <p class='donne-gtrs-car-en'>
                   $descriptionHtml
                </p>
              </div>
              <div class='frame-5'>
                <a href=$link> <div class='text-wrapper-5'>Voir l’annonce</div></a>
                <a href=$link><img class='icon-arrow-right' src='../../../../../../~cayraca/projetPhp/e-commerce/ressources/img/icon-arrow-right.png' /></a>
              </div>
              <a href='$lienPanier' class='lien-panier'>Ajouter au panier</a>
            </div>
          </div>";

        }


        /** @var array $voitures */


        ?>

    </div>
</div>






