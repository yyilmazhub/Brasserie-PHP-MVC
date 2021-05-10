<?php

class Mouvement {

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

    //Retourne toutes les infos de tout les mouvements
    public function getInfosMouvement($id) {

        $sql = "SELECT * FROM mouvement WHERE id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    //Retourne les infos des mouvements choisi dans un intervalle de date
    public function getMouvementDate() {

        $sql = "SELECT * FROM mouvement WHERE date BETWEEN :dateMin AND :dateMax";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':dateMin', $dateMin, PDO::PARAM_STR);
        $requete->bindParam(':dateMax', $dateMax, PDO::PARAM_STR);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMouvementParBrassin($code) {
        $sql = "SELECT * FROM mouvement WHERE code = :code";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':code', $code, PDO::PARAM_STR);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    //Créé un nouveau mouvement
    public function ajoutMouvement($date, $contenance, $nbBouteilles, $code) {

        $sql = "INSERT INTO mouvement (date, contenance, nbBouteilles, code) VALUES (:date, :contenance, :nbBouteilles, :code)";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':date', $date, PDO::PARAM_STR);
        $requete->bindParam(':contenance', $contenance, PDO::PARAM_STR);
        $requete->bindParam(':nbBouteilles', $nbBouteilles, PDO::PARAM_INT);
        $requete->bindParam(':code', $code, PDO::PARAM_STR);

        return $requete->execute();
    }

    //Modifie un mouvement existant
    public function modifierMouvement() {

    }

    //Supprime un mouvement
    public function supprimerMouvement($id) {

        $sql = "DELETE FROM mouvement WHERE id = :id";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':id', $id, PDO::PARAM_INT);

        return $requete->execute();
    }

    public function afficherTableauBrassin() {

        $sql = "SELECT brassin.code, brassin.dateBrass, biere.nom, brassin.pourAlcool, brassin.volume, brassin.dateMiseBout, mouvement.contenance, COUNT(mouvement.contenance)";
        $sql = $sql." FROM brassin";
        $sql = $sql." INNER JOIN biere ON biere.id = brassin.id";
        $sql = $sql." LEFT JOIN mouvement ON mouvement.code = brassin.code";
        $sql = $sql." GROUP BY mouvement.contenance";
        $sql = $sql." ORDER BY brassin.dateBrass DESC, brassin.code DESC";

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficherTableauMouvement() {

        $sql = "SELECT mouvement.code, mouvement.date, biere.nom, brassin.pourAlcool, mouvement.contenance, mouvement.stockDebMois, mouvement.stockRealise, mouvement.sortiesVendues, mouvement.sortiesDeg, mouvement.stockFinMois, mouvement.volSorties, mouvement.coutDouanes";
        $sql = $sql." FROM mouvement";
        $sql = $sql." INNER JOIN brassin ON mouvement.code = brassin.code";
        $sql = $sql." INNER JOIN biere ON brassin.id = biere.id";
        $sql = $sql." ORDER BY mouvement.date DESC";

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>