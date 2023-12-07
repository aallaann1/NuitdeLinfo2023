<?php

use App\Lib\ConnexionUtilisateur;

/** @var \App\Modele\DataObject\Utilisateur $utilisateur */
$loginHTML=htmlspecialchars($utilisateur->getLogin());
$nomHTML=htmlspecialchars($utilisateur->getNom());
$prenomHTML=htmlspecialchars($utilisateur->getPrenom());
$emailHTML=htmlspecialchars($utilisateur->getEmail());
$estAdminHTML=$utilisateur->getEstAdmin();
if (strlen($utilisateur->getEmail())!=0){
    $emailHTML=htmlspecialchars($utilisateur->getEmail());
}else{
    $emailHTML=htmlspecialchars($utilisateur->getEmailAValider());
}
$login=htmlspecialchars($utilisateur->getLogin());

echo "
<div class='formulaire'>
    <form method='post' action='?action=mettreAJour&controleur=utilisateur&login'>

        <div class='fieldsetBackEnd' id='inscription'>
            <fieldset>
                <legend>Mise a jour : </legend>
                <p>
                    <label for='login'>login :</label>
                    <input type='text' value=$loginHTML name='login' id='login' readonly/>
                </p>
                <p>
                    <label for='nom'>nom :</label>
                    <input type='text' value='$nomHTML' name='nom' id='nom' required/>
                </p>
                <p>
                    <label for='prenom'>prenom :</label>
                    <input type='text' value=$prenomHTML name='prenom' id='prenom' required/>
                </p>
                <p>
                    <label for='Amdp'>ancien mot de passe :</label>
                    <input type='password' value='' placeholder='' name='Amdp' id='Amdp' required>
                </p>
                <p>
                    <label for='mdp'>nouveau mot de passe :</label>
                    <input type='password' value='' placeholder='' name='mdp' id='mdp' >
                </p>
                <p>
                    <label for='mdp2'>verifier nouveau mot de passe :</label>
                    <input type='password' value='' placeholder='' name='mdp2' id='mdp2' >
                </p>
                <p>
                    <label for='email'>email :</label>
                    <input type='email' value=$emailHTML name='email' id='email' required>
                </p>";
                if (ConnexionUtilisateur::estAdministrateur()) {
                    if ($estAdminHTML){
                        echo "
                <p>
                    <label for='estAdmin'>administrateur</label>
                    <input type='checkbox' name='estAdmin' id='estAdmin' checked>
                </p>";
                    }else{
                        echo "
                <p>
                    <label for='estAdmin'>administrateur</label>
                    <input type='checkbox' name='estAdmin' id='estAdmin'>
                </p>";
                    }
                }
                echo "
                <p>
                    <input type='hidden' name='action' value='mettreAJour'>
                    <input type='hidden' name='controleur' value='utilisateur'>
                    <input type='submit' value='Envoyer' />
                </p>
            </fieldset>
        </div>
    </form>
</div>";
