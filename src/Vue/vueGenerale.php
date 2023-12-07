<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php /** @var TYPE_NAME $pagetitle */
        echo $pagetitle; ?></title>
    <link href="../ressources/css/style.css" rel="stylesheet">
    <link href="../ressources/css/globals.css" rel="stylesheet">
</head>
<body>
<div class="landing">
    <header class="header">
        <div class="text-wrapper">
            <a href="controleurFrontal.php" style="color: white;">Godasse.org</a>
        </div>

        <div class="liens">

        </div><?php
        use App\Lib\ConnexionUtilisateur;


        // Vérifier si aucun utilisateur n'est pas connecté
        if (!ConnexionUtilisateur::estConnecte()) {
            echo '<div class="div"><a href="controleurFrontal.php" style="color: white;">Trouver une annonce</a></div>';
            echo '<div class="div"><a href="controleurFrontal.php?action=afficherFormulaireInscription&controleur=utilisateur"  style="color: white;" >Inscription</a></div>';
            echo '<div class="div"> <a href="controleurFrontal.php?action=afficherFormulaireConnexion&controleur=utilisateur"  style="color: white;" >Connexion</a></div>';
        }

        // Vérifier si l'utilisateur est connecté
        if (ConnexionUtilisateur::estConnecte()) {
            $log = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            echo '<div class="div"><a href="controleurFrontal.php?action=afficherDetail&controleur=utilisateur&login=' . urlencode($log) . '"  style="color: white;" >mon compte</a></div>';
            echo '<div class="div"><a href="controleurFrontal.php?action=deconnecter&controleur=utilisateur"  style="color: white;" >deconnexion</a></div>';
            echo '<div class="div"><a href="controleurFrontal.php?action=afficherCommandes&controleur=commande"  style="color: white;" >mes commandes</a></div>';

            //Vérifier si l'utilisateur est administrateur
            if (ConnexionUtilisateur::estAdministrateur()) {
                echo '<div class="div"><a href="controleurFrontal.php?action=afficherFormulaireCreation&controleur=chaussure"  style="color: white;" >Ajouter une annonce</a></div>';
                echo '<div class="div"><a href="?action=afficherListe&controleur=utilisateur"  style="color: white;" >Afficher Utilisateurs</a></div>';
                echo '<div class="div"><a href="?action=afficherGestionCommande&controleur=commande"  style="color: white;" >Gestion commande</a></div>';
            }else{
                echo '<div class="div"><a href="controleurFrontal.php" style="color: white;">Trouver une annonce</a></div>';
            }

        }
        ?>

        <div class="div">A propos</div>
        <div class="div">
            <a href="controleurFrontal.php?action=afficherPanier&controleur=panier"  style="color: white;" >Panier </a>
        </div>
    </header>

    <?php
    /** @var string[][] $messagesFlash */
    foreach($messagesFlash as $type => $messagesFlashPourUnType) {
        // $type est l'une des valeurs suivantes : "success", "info", "warning", "danger"
        // $messagesFlashPourUnType est la liste des messages flash d'un type
        foreach ($messagesFlashPourUnType as $messageFlash) {
            echo <<< HTML
            <div class="alert alert-$type">
               $messageFlash
            </div>
            HTML;
        }
    }
    ?>

<main>
    <?php
    /** @var TYPE_NAME $cheminVueBody */
    require __DIR__ . "/vueGenerale.php";
    ?>
</main>

   <footer class="footer">
        <div class="liens-2">
            <div class="div"><a href="controleurFrontal.php" style="color: white;">Trouver une annonce</a></div>
          <div class="div">A propos</div>
           <div class="div">Conditions Générales</div>
        </div>
   </footer>

</div>
</body>
</html>