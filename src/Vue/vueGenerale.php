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
<div class="container">
    <header>

        <div class="nav">
            <a href="controleurFrontal.php" style="color: white;">Arbre.org</a>


        <?php
        use App\Lib\ConnexionUtilisateur;

        echo '<nav>';

        // Vérifier si aucun utilisateur n'est pas connecté
        if (!ConnexionUtilisateur::estConnecte()) {
            echo '<li><a href="controleurFrontal.php" style="color: white;">Trouver une annonce</a></li>';
            echo '<li><a href="controleurFrontal.php?action=afficherFormulaireInscription&controleur=utilisateur"  style="color: white;" >Inscription</a></li>';
            echo '<li><a href="controleurFrontal.php?action=afficherFormulaireConnexion&controleur=utilisateur"  style="color: white;" >Connexion</a></li>';
        }

        // Vérifier si l'utilisateur est connecté
        if (ConnexionUtilisateur::estConnecte()) {
            $log = ConnexionUtilisateur::getLoginUtilisateurConnecte();
            echo '<li><a href="controleurFrontal.php?action=afficherDetail&controleur=utilisateur&login=' . urlencode($log) . '"  style="color: white;" >mon compte</a></li>';
            echo '<li><a href="controleurFrontal.php?action=deconnecter&controleur=utilisateur"  style="color: white;" >deconnexion</a></li>';
            echo '<li><a href="controleurFrontal.php?action=afficherCommandes&controleur=commande"  style="color: white;" >mes commandes</a></li>';

            //Vérifier si l'utilisateur est administrateur
            if (ConnexionUtilisateur::estAdministrateur()) {
                echo '<li><a href="controleurFrontal.php?action=afficherFormulaireCreation&controleur=arbre"  style="color: white;" >Ajouter une annonce</a></li>';
                echo '<li><a href="?action=afficherListe&controleur=utilisateur"  style="color: white;" >Afficher Utilisateurs</a></li>';
                echo '<li><a href="?action=afficherGestionCommande&controleur=commande"  style="color: white;" >Gestion commande</a></li>';
            }else{
                echo '<li><a href="controleurFrontal.php" style="color: white;">Trouver une annonce</a>';
            }

        }
        ?>

        <div class="div">A propos</div>
            <li><a href="controleurFrontal.php?action=afficherPanier&controleur=panier"  style="color: white;" >Panier </a></li>

            <div class="burger-menu" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <ul class="nav-links">
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
        </nav>
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

<main class="container">
    <?php
    /** @var TYPE_NAME $cheminVueBody */
    require __DIR__ .  "/{$cheminVueBody}";
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