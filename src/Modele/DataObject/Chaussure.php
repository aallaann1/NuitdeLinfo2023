<?php

namespace App\Modele\DataObject;


use App\Modele\Repository\AbstractRepository;

class Chaussure extends AbstractDataObject
{

    private $idChaussure;
    private $photo;
    private $nom;
    private $taille;
    private $prix;
    private $description;

    public function __construct($idChaussure, $photo, $nom, $taille, $prix, $description)
    {
        $this->idChaussure = $idChaussure;
        $this->photo = $photo;
        $this->nom = $nom;
        $this->taille = $taille;
        $this->prix = $prix;
        $this->description = $description;
    }

    public function afficher()
    {
        echo "idChaussure : " . $this->idChaussure . "<br>";
        echo "photo : " . $this->photo . "<br>";
        echo "nom : " . $this->nom . "<br>";
        echo "taille : " . $this->taille . "<br>";
        echo "prix : " . $this->prix . "<br>";
        echo "description : " . $this->description . "<br>";
    }



    /**
     * @return mixed
     */
    public function getIdChaussure()
    {
        return $this->idChaussure;
    }

    /**
     * @param mixed $id
     */
    public function setIdChaussure($idChaussure): void
    {
        $this->idChaussure = $idChaussure;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param mixed $taille
     */
    public function setTaille($taille): void
    {
        $this->taille = $taille;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }




    public function formatTableau(): array
    {
        return array(
            "idChaussure" => $this->idChaussure,
            "photo" => $this->photo,
            "nom" => $this->nom,
            "taille" => $this->taille,
            "prix" => $this->prix,
            "description" => $this->description
        );
    }
}

?>