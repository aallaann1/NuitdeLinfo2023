<div class="landing">
    <div class="search">
        <p class="trouver-une-annonce">
            <span class="span">Trouver un</span>
            <span class="text-wrapper-2">arbre</span>
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

        /** @var  array $arbres */
        $arbres[] = (new \App\Modele\Repository\ArbreRepository())->recuperer();
        $ligneActuelle = 0;
        $modulo = sizeof($arbres)%3;
        $nbLigne = intdiv(sizeof($arbres),3);
        if ($nbLigne>0 && $modulo==0){
            $nbLigne--;
        }
        $colonne = 0;
        $indice = 0;
        $autorise = 2;


        foreach ($arbres as $arbre) {


            $nomHtml = htmlspecialchars($arbre->getNomcommun());
            $descriptionHtml = htmlspecialchars($arbre->getDescription());
            $image = $arbre->getImage();
            $link = urldecode("?action=afficherDetail&idChaussure=".$arbre->getIdArbre());
            $lienModifier = urldecode("?action=afficherFormulaireMiseAJour&controleur=chaussure&idChaussure=".$arbre->getIdArbre());
            $lienSupprimer = urldecode("?action=supprimer&controleur=chaussure&idChaussure=".$arbre->getIdArbre());
            $urlDuPanier = urldecode("?action=ajouterAuPanier&controleur=panier&idChaussure=".$arbre->getIdArbre());

            if ($modulo==0){
                $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
            }else if ($modulo==1){
                if ($indice==$nbLigne){
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $nbLigne--;
                }else{
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $indice++;
                }
            }else{
                if ($indice==$nbLigne){
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $autorise--;
                    if ($autorise==0) {
                        $nbLigne--;
                        $indice++;
                    }else{
                        $indice=0;
                    }
                }else{
                    $ligneActuelle=afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$link,$lienModifier,$lienSupprimer,$urlDuPanier);
                    $indice++;
                }
            }

        }






        function afficherEnFonctionModulo($modulo,$image,$descriptionHtml,$nomHtml,$ligneActuelle,$nbLigne,$link,$lienModifier,$lienSupprimer,$lienPanier) : int
        {
            if ($nbLigne==0){
                echo "<div class='frame-2'>";
                affichageAnnonce($nomHtml,$descriptionHtml,$image,$link,$lienModifier,$lienSupprimer,$lienPanier);
                echo"</div>";
                return 0;
            }

            else if ($modulo==0){
                if ($ligneActuelle==0){
                    echo "<div class='frame-2'>";
                }

                affichageAnnonce($nomHtml,$descriptionHtml,$image,$link,$lienModifier,$lienSupprimer,$lienPanier);

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

                affichageAnnonce($nomHtml,$descriptionHtml,$image,$link,$lienModifier,$lienSupprimer,$lienPanier);

                if ($ligneActuelle==$nbLigne){
                    echo"</div>";
                    return 0;

                }else{
                    $ligneActuelle++;
                }
                return $ligneActuelle;
            }
        }


        function affichageAnnonce($nomHtml, $descriptionHtml, $image,$link,$lienModifier,$lienSupprimer,$lienPanier)
        {
            echo "<div class='annonce'>
            <img class='rectangle' src='data:image/jpeg;base64," . base64_encode($image) . "' />
            <div class='frame-3'>
              <div class='frame-4'>
                <div class='title'>
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


        /** @var array $arbres */


        ?>

    </div>
</div>






