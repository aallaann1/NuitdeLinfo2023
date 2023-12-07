<?php
namespace App\Lib;

use App\Modele\HTTP\Session;

class MessageFlash
{

    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        $messageFlash = Session::getInstance()->lire(MessageFlash::$cleFlash);
        if ($messageFlash == ''){
            $messageFlash = array($type => array($message));
        }else {
            $messageFlash = $messageFlash + array($type => array($message));
        }
        Session::getInstance()->enregistrer(MessageFlash::$cleFlash, $messageFlash);
    }

    public static function contientMessage(string $type): bool
    {

        $messages = Session::getInstance()->lire(MessageFlash::$cleFlash);

        if (is_array($messages)) {
            foreach ($messages as $message) {
                if (isset($message['type']) && $message['type'] === $type) {
                    return true;
                }
            }
        }

        return false;
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        $messages = Session::getInstance()->lire(MessageFlash::$cleFlash);
        $messagesToReturn = [];

        if (is_array($messages)) {
            foreach ($messages as $index => $message) {
                if (isset($message['type']) && $message['type'] === $type) {
                    $messagesToReturn[] = $message;
                    // Supprimer le message de la liste une fois lu
                    unset($messages[$index]);
                }
            }

            // Mettre à jour les messages restants en session
            Session::getInstance()->enregistrer(MessageFlash::$cleFlash, $messages);
        }

        return $messagesToReturn;
    }

    public static function lireTousMessages() : array
    {
        $messages = Session::getInstance()->lire(MessageFlash::$cleFlash);

        if (is_array($messages)) {
            // Effacer tous les messages après lecture
            Session::getInstance()->supprimer(MessageFlash::$cleFlash);
            return $messages;
        }

        return [];
    }

}

