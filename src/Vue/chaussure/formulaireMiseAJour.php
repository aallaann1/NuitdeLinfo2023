<?php
/** @var integer $idChaussure */
/** @var \App\Modele\DataObject\Chaussure $chaussure */
$idChaussureHTML = htmlspecialchars($idChaussure);
$photoHTML = ($chaussure->getPhoto());
$nomHTML = htmlspecialchars($chaussure->getNom());
$tailleHTML = htmlspecialchars($chaussure->getTaille());
$prixHTML = htmlspecialchars($chaussure->getPrix());
$descriptionHTML = htmlspecialchars($chaussure->getDescription());

echo "<div class='formulaire'>
    <form method='post' action='?action=mettreAJour&controleur=chaussure'>

        <fieldset class='fieldsetBackEnd'>
            <legend>Formulaire modification chaussure : </legend>
            <p>
                <label for='idChaussure'>Id Chaussure : </label>
                <input type='text' value='$idChaussureHTML' name='idChaussure' id='idChaussure' required readonly/>
            </p>
            <p>
                <label for='photo'>Photo actuelle : </label>
                <img src='data:image/jpeg;base64," . base64_encode($photoHTML) . "' id='imageFormulaireMaj''/>
            </p>
            <p>
                <label for='nouvellePhoto'>Nouvelle Photo : </label>
                <input type='file' name='nouvellePhoto' id='nouvellePhoto' accept='image/*'/>
            </p>
            <p>
                <label for='nom'>Nom : </label>
                <input type='text' value='$nomHTML' name='nom' id='nom' required/>
            </p>
            <p>
                <label for='taille'>Taille : </label>
                <input type='number' value='$tailleHTML' name='taille' id='taille' required/>
            </p>
            <p>
                <label for='prix'>Prix : </label>
                <input type='number' value='$prixHTML' name='prix' id='prix' required/>
            </p>
            <p>
                <label for='description'>Description : </label>
                <input type='text' value='$descriptionHTML' name='description' id='description' required/>
            </p>
            <p>
                <input type='hidden' name='action' value='mettreAJour'>
                <input type='hidden' name='controleur' value='chaussure'>
                <input type='submit' value='Envoyer'/>
            </p>
        </fieldset>
    </form>
</div>";
