<?php

namespace App\Modele\DataObject;


use App\Modele\Repository\AbstractRepository;
use App\Modele\Repository\ArbreRepository;

class Arbre extends AbstractDataObject
{

    private $idArbre;
    private $nomScientifique;
    private $nomcommun;
    private $image;
    private $description;

    public function __construct($idArbre, $nomScientifique, $nomcommun, $image, $description)
    {
        $this->idArbre = $idArbre;
        $this->nomScientifique = $nomScientifique;
        $this->nomcommun = $nomcommun;
        $this->image = $image;
        $this->description = $description;
    }

    public function afficher()
    {
        echo "idArbre : " . $this->idArbre . "<br>";
        echo "nomScientifique : " . $this->nomScientifique . "<br>";
        echo "nomcommun : " . $this->nomcommun . "<br>";
        echo "image : " . $this->image . "<br>";
        echo "description : " . $this->description . "<br>";
    }

    /**
     * @return mixed
     */
    public function getIdArbre()
    {
        return $this->idArbre;
    }

    /**
     * @param mixed $idArbre
     */
    public function setIdArbre($idArbre): void
    {
        $this->idArbre = $idArbre;
    }

    /**
     * @return mixed
     */
    public function getNomScientifique()
    {
        return $this->nomScientifique;
    }

    /**
     * @param mixed $nomScientifique
     */
    public function setNomScientifique($nomScientifique): void
    {
        $this->nomScientifique = $nomScientifique;
    }

    /**
     * @return mixed
     */
    public function getNomcommun()
    {
        return $this->nomcommun;
    }

    /**
     * @param mixed $nomcommun
     */
    public function setNomcommun($nomcommun): void
    {
        $this->nomcommun = $nomcommun;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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


    public function formatTableau(): array
    {
        return array(
            "idArbre" => $this->idArbre,
            "nomScientifique" => $this->nomScientifique,
            "nomcommun" => $this->nomcommun,
            "image" => $this->image,
            "description" => $this->description
        );
    }

    public static function getArbre($idArbre): Arbre
    {
        $arbre = (new ArbreRepository())->recupererParClePrimaire($idArbre);
        return $arbre;
    }
}

?>