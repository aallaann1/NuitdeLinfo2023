<div class="formulaire">
<form method="post" action="?action=creerDepuisFormulaire&controleur=arbre" enctype="multipart/form-data">

    <fieldset class="fieldsetBackEnd">
        <legend>Formulaire creation d'arbre : </legend>
        <p>
            <label for="nomScientifique">Nom Scientifique : </label>
            <input type="text" name="nomScientifique" id="nomScientifique" required />
        </p>
        <p>
            <label for="nomcommun">Nom commun : </label>
            <input type="text" name="nomCommun" id="nomcommun" required />
        </p>
        <p>
            <label for="image">Image : </label>
            <input type="text" name="image" id="image" required />
        </p>
        <p>
            <label for="description">Description : </label>
            <input type="text" name="description" id="description" required />
        </p>

            <input type="hidden" name="action" value="creerDepuisFormulaire">
            <input type="hidden" name="controleur" value="arbre">
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
</div>