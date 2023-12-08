<?php
namespace App\Modele\Repository;


use App\Modele\DataObject\AbstractDataObject;
use PDO;
abstract class AbstractRepository{

    /**
     * @return AbstractDataObject[]
     */


    public function recuperer(): array{
        $table = $this->getNomTable();
        $tab=[];

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query("SELECT * FROM ". $table);
        foreach ($pdoStatement as $o){
            $tab[]=$this::construireDepuisTableau($o);
        }
        return $tab;
    }

    public function recupererParClePrimaire(string $valeurClePrimaire): ?AbstractDataObject{
        $object = $this->getNomTable();
        $nomClePrimaire = $this->getNomClePrimaire();
        $sql = "SELECT * FROM $object WHERE $nomClePrimaire = :clePrimaireTag";
        $values = array("clePrimaireTag" => $valeurClePrimaire);

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $objectFormatTableau = $pdoStatement->fetch();
        if ($objectFormatTableau === false) return null;
        return $this->construireDepuisTableau($objectFormatTableau);
    }

    public function recupererParClePrimaireArray(string $valeurClePrimaire): ?array {
        $object = $this->getNomTable();
        $nomClePrimaire = $this->getNomClePrimaire();
        $sql = "SELECT * FROM $object WHERE $nomClePrimaire = :clePrimaireTag";
        $values = array("clePrimaireTag" => $valeurClePrimaire);

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $resultats = $pdoStatement->fetchAll();

        $paniers = [];
        foreach ($resultats as $resultat) {
            $paniers[] = $this->construireDepuisTableau($resultat);
        }

        return $paniers;
    }

    public function supprimer($valeurClePrimaire){
        $table=$this->getNomTable();
        $nomClePrimaire = $this->getNomClePrimaire();
        $sql = "DELETE FROM $table WHERE $nomClePrimaire= :clePrimaireTag";
        $array = [
            "clePrimaireTag" => $valeurClePrimaire
        ];
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($array);
    }

    public function supprimerParClePrimaire(string $valeurClePrimaire1, string $valeurClePrimaire2): void
    {
        $table = $this->getNomTable();
        $nomClePrimaire1 = $this->getNomClePrimaire();
        $nomClePrimaire2 = $this->getNomClePrimaire();
        $sql = "DELETE FROM $table WHERE $nomClePrimaire1 = :clePrimaireTag1 AND $nomClePrimaire2 = :clePrimaireTag2";
        $array = [
            "clePrimaireTag1" => $valeurClePrimaire1,
            "clePrimaireTag2" => $valeurClePrimaire2
        ];
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($array);
    }
    public function mettreAJour(AbstractDataObject $objet): AbstractDataObject
    {
        $pdo = ConnexionBaseDeDonnee::getPdo();
        $table = $this->getNomTable();
        $clePrimaire = $this->getNomClePrimaire();
        $colonnes = $this->getNomsColonnes();
        $values = $objet->formatTableau();

        $sql = "UPDATE $table SET ";
        foreach ($colonnes as $colonne) {
            $sql .= "$colonne = :$colonne, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE $clePrimaire = :$clePrimaire";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        try {
            $pdoStatement->execute($values);
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour de l'objet : " . $e->getMessage());
        }

        return $objet;
    }

    public function sauvegarder(AbstractDataObject $objet): AbstractDataObject
    {
        $pdo = ConnexionBaseDeDonnee::getPdo();
        $table = $this->getNomTable();
        $colonnes = $this->getNomsColonnes();
        $values = $objet->formatTableau();

        $sql = "INSERT INTO $table (";
        foreach ($colonnes as $colonne) {
            $sql .= "$colonne, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ") VALUES (";
        foreach ($colonnes as $colonne) {
            $sql .= ":$colonne, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= ")";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        try {
            $pdoStatement->execute($values);
        } catch (PDOException $e) {
            die("Erreur lors de l'insertion de l'objet : " . $e->getMessage());
        }

        return $objet;
    }



    protected abstract function getNomTable(): string;
    protected abstract function construireDepuisTableau(array $objetFormatTableau) : AbstractDataObject;

    protected abstract function getNomClePrimaire(): string;

    protected abstract function getNomsColonnes(): array;


}