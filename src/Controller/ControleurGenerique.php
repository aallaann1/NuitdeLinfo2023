<?php

namespace App\Controller;
use App\Lib\MessageFlash;
use App\Modele\Repository;

class ControleurGenerique
{

    public static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres);
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../Vue/$cheminVue";
    }

    public static function afficherErreur($messageErreur): void {

        ControleurGenerique::afficherVue('vueGenerale.php', ['pagetitle' => 'Erreur', 'cheminVueBody' => 'erreur.php', 'messageErreur' => $messageErreur]);
    }


    public static function redirectionVersURL($url):void{
        header("Location: $url");
        exit();
    }



}