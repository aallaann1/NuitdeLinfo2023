<?php
echo "<p><strong>Les Produits :</strong></p>"; //Sa c'est le titre du Body (le truc écrit en gros en dessous du header)

/** @var \DataObject\Produit $produits */
foreach ($produits as $p){
    $nomP = htmlspecialchars($p->getNom());
    $prixP = $p->getPrix();

    $lienDetail = ''; // A faire : mettre le lien de l'action detail du produit + son id ou nom (cela dépend de sa clé primaire)

    echo "<p>nom : " . $nomP . "</p>";
    echo "<p>prix : " . $prixP . "</p><br>";
    echo "<a href='".$lienDetail."'>Detail</a>";
}