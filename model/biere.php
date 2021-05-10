<?php

class Biere {

    //Objet PDO pour la connexion à la base
    private $pdo;

    //Connexion à la base de données
    public function __construct() {
        $config = parse_ini_file("config.ini");

        try {
            $this->pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
        }
        catch(Exception $except) {
            echo $except->getMessage();
        }
    }

    public function getAllBiere() {
        $sql = "SELECT * FROM biere";

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    //Retourne toutes les infos de toutes les bières
    public function getInfosBiere($idBiere) {
        $sql = "SELECT * FROM biere WHERE id = :idBiere";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':idBiere', $idBiere, PDO::PARAM_INT);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBiereParBrassin($code) {
        $sql = "SELECT nom FROM biere";
        $sql = $sql." INNER JOIN brassin ON biere.id = brassin.id";
        $sql = $sql." WHERE brassin.code = :code";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':code', $code, PDO::PARAM_STR);
        $requete->execute();

        return $requete->fetch();
    }

    //Créé une nouvelle bière
    public function creerBiere($nom) {
        $sql = "INSERT INTO biere (nom) VALUES (:nom)";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        
        return $requete->execute();
    }

    //Modifie une bière existante
    public function modifierBiere($nom, $id) {
        $sql = "UPDATE biere SET nom = :nom WHERE id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->bindParam(':id', $id, PDO::PARAM_INT);

        return $requete->execute();
    }

    //Supprime une bière
    public function supprimerBiere($id) {
        $sql = "SELECT code FROM brassin WHERE id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        $codesBrassins = $requete->fetchAll(PDO::FETCH_ASSOC);

        foreach($codesBrassins as $codeBrassin)
        {
            $sql = "DELETE FROM mouvement WHERE code = :code; DELETE FROM brassin WHERE code = :code";

            $requete = $this->pdo->prepare($sql);
            $requete->bindParam(':code', $codeBrassin, PDO::PARAM_STR);

            $requete->execute();
        }
        
        $sql = "DELETE FROM biere WHERE id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':id', $id, PDO::PARAM_INT);

        return $requete->execute();
    }
}

?>