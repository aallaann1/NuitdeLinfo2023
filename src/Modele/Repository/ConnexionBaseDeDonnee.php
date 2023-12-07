<?php

namespace App\Modele\Repository;

use App\Configuration\Configuration;
use PDO;

class ConnexionBaseDeDonnee {
    private static ?ConnexionBaseDeDonnee $instance = null;
    private PDO $pdo;


    // Méthode statique pour obtenir l'instance unique de Model
    public static function getInstance(): ConnexionBaseDeDonnee {
        if (is_null(self::$instance)) {
            self::$instance = new ConnexionBaseDeDonnee();
        }
        return self::$instance;
    }

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {
        $hostname = Configuration::getHostName();
        $port = Configuration::getPort();
        $databaseName = Configuration::getDataBase();
        $login = Configuration::getLogin();
        $password = Configuration::getPassword();

        $this->pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$databaseName", $login, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

// On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Méthode pour obtenir la connexion PDO
    public static function getPdo(): PDO {
        return ConnexionBaseDeDonnee::getInstance()->pdo;
    }
}