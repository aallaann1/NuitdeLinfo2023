<?php
/** @var array $arbre */
$nomScientifiqueHtml = htmlspecialchars($arbre->getNomScientifique());
$nomHtml = htmlspecialchars($arbre->getNomcommun());
$image = $arbre->getImage();
$descriptionHtml = htmlspecialchars($arbre->getDescription());
$urlDuPanier = urldecode("?action=ajouterAuPanier&controleur=panier&idArbre=".$arbre->getIdArbre());

echo "
<div class='formulaire'>
    <div class='article'>
        <div class='annonces-2'>
            <div class='img-container'>
                <img class='rectangle-2' src='data:image/jpeg;base64," . base64_encode($image) . "$image' />
            </div>
            <div id='reste'>
            <div class='frame2'>
                <div class='frame-2-2'>
                    <div class='text-wrapper-3-2'>$nomHtml</div>
                </div>
            </div>
            
            <div class='frame2'>
                <div class='text-wrapper-4-2'>Caractéristiques</div>
                <div class='frame-3-2'>
                    <div class='frame-4-2'>
                        <div class='text-wrapper-5-2'>Nom Scientifique :</div>
                        <div class='text-wrapper-6-2'>$nomScientifiqueHtml</div>
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

