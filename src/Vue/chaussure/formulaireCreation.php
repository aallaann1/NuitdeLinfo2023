<div class="formulaire">
<form method="post" action="?action=creerDepuisFormulaire&controleur=chaussure" enctype="multipart/form-data">

    <fieldset class="fieldsetBackEnd">
        <legend>Formulaire creation chaussure : </legend>
        <p>
            <label for="idChaussure">Id Chaussure : </label>
            <input type="text" placeholder="0" name="idChaussure" id="idChaussure" required/>
        </p>
        <p>
            <label for="photo">Photo : </label>
            <input type="file" name="photo" id="photo" accept="image/*" required/>
        </p>
        <p>
            <label for="nom">Nom : </label>
            <input type="text" placeholder="Jordan 1" name="nom" id="nom" required/>
        </p>
        <p>
            <label for="nom">Taille : </label>
            <input type="number" placeholder="42" name="taille" id="taille" required/>
        </p>
        <p>
            <label for="prix">Prix : </label>
            <input type="number" placeholder="110" name="prix" id="prix" required/>
        </p>
        <p>
            <label for="description">Description : </label>
            <input type="text" name="description" id="description" required/>
        </p>
        <p>
            <input type="hidden" name="action" value="creerDepuisFormulaire">
            <input type="hidden" name="controleur" value="chaussure">
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>
</div>