<?php

namespace App\Modele\DataObject;

use App\Lib\MotDePasse;
use App\Lib\VerificationEmail;


class Utilisateur extends AbstractDataObject
{
    private string $login;
    private string $nom;
    private string $prenom;
    private string $mdpHache;
    private bool $estAdmin;
    private string $email;
    private string $emailAValider;
    private string $nonce;

    public function __construct(string $login, string $nom, string $prenom, string $mdpHache, bool $estAdmin, string $email, string $emailAValider, string $nonce)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdpHache = $mdpHache;
        $this->estAdmin = $estAdmin;
        $this->email = $email;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
    }

    public static function construireDepuisTableau(array $utilisateurTableau) : Utilisateur {
        return new Utilisateur(
            $utilisateurTableau["login"],
            $utilisateurTableau["nom"],
            $utilisateurTableau["prenom"],
            $utilisateurTableau["mdpHache"],
            $utilisateurTableau["estAdmin"],
            $utilisateurTableau["email"],
            $utilisateurTableau["emailAValider"],
            $utilisateurTableau["nonce"]
        );
    }

    public static function construireDepuisFormulaire(array $donneesFormulaire): Utilisateur
    {
        $mdp = MotDePasse::hacher($donneesFormulaire['mdp']);
        $nonce = MotDePasse::genererChaineAleatoire();


        $utilisateur = new Utilisateur(
            $donneesFormulaire['login'],
            $donneesFormulaire['nom'],
            $donneesFormulaire['prenom'],
            $mdp,
            $donneesFormulaire['estAdmin'],
            '',
            $donneesFormulaire['email'],
            $nonce,
        );

        VerificationEmail::envoiEmailValidation($utilisateur);

        return $utilisateur;
    }


    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
    }

    public function getEmailAValider(): string
    {
        return $this->emailAValider;
    }

    public function setEmailAValider(string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEstAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }

    public function __toString() : string {
        return "<p> Utilisateur {$this->prenom} {$this->nom} de login {$this->login} </p>";
    }

    /**
     * @return Utilisateur[]
     */
    public static function getUtilisateurs() : array {
        $pdoStatement = Model::getPdo()->query("SELECT * FROM utilisateur");

        $utilisateurs = [];
        foreach($pdoStatement as $utilisateurFormatTableau) {
            $utilisateurs[] = Utilisateur::construireDepuisTableau($utilisateurFormatTableau);
        }

        return $utilisateurs;
    }

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }

    public function formatTableau(): array
    {
        if ($this->getEstAdmin()){
            $adminValue = 1;
        }else{
            $adminValue = 0;
        }
        return [
            'login' => $this->getLogin(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'mdpHache' => $this->getMdpHache(),
            'estAdmin' =>$adminValue,
            'email' => $this->getEmail(),
            'emailAValider' => $this->getEmailAValider(),
            'nonce' => $this->getNonce()
        ];
    }
}