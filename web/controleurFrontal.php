<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\Lib\Psr4AutoloaderClass();
$loader->register();

$loader->addNamespace('App', __DIR__ . '/../src');



$controleurParDefaut = 'chaussure';


$controleurAffichage = 'App\Controller\Controleur' . ucfirst($controleurParDefaut);



if (class_exists($controleurAffichage)) {

    /** @var string $ControleurAffichage */
    if (isset($_GET['action'])) {
        if (isset($_GET['controleur'])) {
            $controleurAffichage= 'App\Controller\Controleur' . ucfirst($_GET['controleur']);
        }
        $action = $_GET['action'];
        $methodes = get_class_methods($controleurAffichage);
        if (in_array($action, $methodes)) {
            $controleurAffichage::$action();
        } else {
            $controleurAffichage::afficherErreur("Action non valide : $action");
        }
    } else {
        $controleurAffichage::afficherListe();
    }

} else {
    echo "Controleur $controleurParDefaut non imlémenté";
}


