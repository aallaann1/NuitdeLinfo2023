<?php
/** @var array $chaussure */
$nomHtml = htmlspecialchars($chaussure->getNom());
$image = $chaussure->getPhoto();
$prixHtml = htmlspecialchars($chaussure->getPrix());
$descriptionHtml = htmlspecialchars($chaussure->getDescription());
$tailleHtml = htmlspecialchars($chaussure->getTaille());
$urlDuPanier = urldecode("?action=ajouterAuPanier&controleur=panier&idChaussure=".$chaussure->getIdChaussure());

echo "
<div class='formulaire'>
    <div class='article'>
        <div class='annonces-2'>
            <div class='img-container'>
                <img class='rectangle-2' src='data:image/jpeg;base64," . base64_encode($image) . "' />
            </div>
            <div id='reste'>
            <div class='frame2'>
                <div class='frame-2-2'>
                    <div class='price-2'><div class='text-wrapper-2-2'>$prixHtml $</div></div>
                    <div class='text-wrapper-3-2'>$nomHtml</div>
                </div>
            </div>
            
            <div class='frame2'>
                <div class='text-wrapper-4-2'>Caractéristiques</div>
                <div class='frame-3-2'>
                    <div class='frame-4-2'>
                        <div class='text-wrapper-5-2'>Taille :</div>
                        <div class='text-wrapper-6-2'>$tailleHtml</div>
                    </div>
                    <div class='frame-4-2'>
                        <div class='text-wrapper-5-2'>Description :</div>
                        <div class='text-wrapper-6-2'>$descriptionHtml</div>
                    </div>
                        <div class='frame-4-2'>
                        <a href='$urlDuPanier' class='lien-panier'>Ajouter au panier</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>";
?>

