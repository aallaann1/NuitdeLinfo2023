<?php

namespace App\Configuration;

class ConfigurationSite{

    private static int $dureeExpiration = 3600; //durée d'expiration de la session en SECONDE

    /**
     * @return int
     */
    public static function getDureeExpiration(): int
    {
        return ConfigurationSite::$dureeExpiration;
    }

    public static function getURLAbsolue(): string {
        return 'https://webinfo.iutmontp.univ-montp2.fr/~cayraca/projetPhp/e-commerce/web/controleurFrontal.php';
    }


    public static function getDebug(): bool{
        return false;
    }

}