<?php if (\App\Configuration\ConfigurationSite::getDebug()){
    $var = "get";
}else{
    $var = "post";
}
?>
<div class="formulaire">
<form method="post" action="?action=connecter&controleur=utilisateur">

    <div class="fieldsetBackEnd">
    <fieldset>
        <legend>Connexion : </legend>
        <p>
            <label for="login">login :</label>
            <input type="text" placeholder="utilisateur33" name="login" id="login" required/>
        </p>
        <p>
            <label for="mdp">mot de passe :</label>
            <input type="password" value="" placeholder="" name="mdp" id="mdp" required>
        </p>
        <p>
            <input type="hidden" name="action" value="connecter">
            <input type="hidden" name="controleur" value="utilisateur">
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
    </div>

</form>
</div>