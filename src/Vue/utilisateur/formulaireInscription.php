<?php

use App\Lib\ConnexionUtilisateur;

?>


<div class="formulaire">
<form method="post" action="?action=creerUtilisateur&controleur=utilisateur">


    <div class="fieldsetBackEnd" id="inscription">
    <fieldset>
        <legend>Inscription : </legend>
        <p>
            <label for="login">login :</label>
            <input type="text" placeholder="utilisateur33" name="login" id="login" required/>
        </p>
        <p>
            <label for="nom">nom :</label>
            <input type="text" placeholder="Durant" name="nom" id="nom" required/>
        </p>
        <p>
            <label for="prenom">prenom :</label>
            <input type="text" placeholder="Fredo" name="prenom" id="prenom" required/>
        </p>
        <p>
            <label for="mdp">mot de passe :</label>
            <input type="password" value="" placeholder="" name="mdp" id="mdp" required>
        </p>
        <p>
            <label for="mdp2">verifier mot de passe :</label>
            <input type="password" value="" placeholder="" name="mdp2" id="mdp2" required>
        </p>
        <p>
            <label for="email">email :</label>
            <input type="email" value="" placeholder="goat@yopmail.com" name="email" id="email" required>
        </p>
        <?php if (ConnexionUtilisateur::estAdministrateur()){
            echo ("<p>
            <label for='estAdmin'>administrateur</label>
            <input type='checkbox' placeholder='' name='estAdmin' id='estAdmin'>
        </p>");
        } ?>
        <p>
            <input type="hidden" name="action" value="creerUtilisateur">
            <input type="hidden" name="controleur" value="utilisateur">
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
    </div>
</form>
</div>