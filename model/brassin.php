<?php

class Brassin {

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

    //Créé un code de brassin avec en premier caractère "B", suivi du nombre de
    //brassins créés dans le mois puis suivi de la date en format "DD-MM-YYYY"
    public function creerIDBrassin($date) {
        $sql = "SELECT COUNT(*) FROM brassin WHERE dateBrass = :date";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':date', $date, PDO::PARAM_STR);
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

        $nbBrassinsDate = 0;
        if($resultat != false)
        {
            $nbBrassinsDate = $resultat[0];
        }

        $DateSplit = explode('-', $date);
        $DateAInserer = $DateSplit[2].$DateSplit[1].$DateSplit[0];

        $IDBrassin = "";

        if($nbBrassinsDate < 10)
        {
            $IDBrassin = "B000".($nbBrassinsDate + 1).$DateAInserer;
        }
        else
        {
            $IDBrassin = "B00".($nbBrassinsDate + 1).$DateAInserer;
        }

        return $IDBrassin;
    }

    public function getAllBrassin() {
        $sql = "SELECT * FROM brassin";

        $requete = $this->pdo->prepare($sql);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    //Retourne toutes les infos de tout les brassins
    public function getInfosBrassin($codeBrassin) {
        $sql = "SELECT * FROM brassin WHERE code = :codeBrassin";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':codeBrassin', $codeBrassin, PDO::PARAM_STR);
        $requete->execute();

        return $requete->fetch();
    }

    //Retourne les infos des brassins choisi dans un intervalle de date
    public function getBrassinPeriode($dateMin, $dateMax) {
        
        $sql = "SELECT * FROM brassin WHERE dateBrass BETWEEN :dateMin AND :dateMax";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':dateMin', $dateMin, PDO::PARAM_STR);
        $requete->bindParam(':dateMax', $dateMax, PDO::PARAM_STR);
        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    //Créé un nouveau brassin
    public function ajoutBrassin($code, $dateBrassin, $volume, $id) {

        $sql = "INSERT INTO brassin (code, dateBrass, volume, id) VALUES (:code, :dateBrass, :volume, :id)";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':code', $code, PDO::PARAM_STR);
        $requete->bindParam(':dateBrass', $dateBrassin, PDO::PARAM_STR);
        $requete->bindParam(':volume', $volume, PDO::PARAM_INT);
        $requete->bindParam(':id', $id, PDO::PARAM_INT);

        return $requete->execute();
    }

    //Modifie un brassin existant
    public function modifierBrassin($code, $dateBrassin, $volume, $id, $pourcentageAlcool, $dateMiseBouteille = null) {

        $sql = "";
        $requete = "";

        if($dateMiseBouteille != null)
        {
            $sql = "UPDATE brassin SET dateBrass = :dateBrass, volume = :volume, id = :id, pourAlcool = :pourAlcool, dateMiseBout = :dateMiseBout WHERE code = :code";

            $requete = $this->pdo->prepare($sql);
            $requete->bindParam(':code', $code, PDO::PARAM_STR);
            $requete->bindParam(':dateBrass', $dateBrassin, PDO::PARAM_STR);
            $requete->bindParam(':volume', $volume, PDO::PARAM_INT);
            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->bindParam(':pourAlcool', $pourcentageAlcool, PDO::PARAM_INT);
            $requete->bindParam(':dateMiseBout', $dateMiseBouteille, PDO::PARAM_STR);
        }
        else
        {
            $sql = "UPDATE brassin SET dateBrass = :dateBrass, volume = :volume, id = :id, pourAlcool = :pourAlcool WHERE code = :code";

            $requete = $this->pdo->prepare($sql);
            $requete->bindParam(':code', $code, PDO::PARAM_STR);
            $requete->bindParam(':dateBrass', $dateBrassin, PDO::PARAM_STR);
            $requete->bindParam(':volume', $volume, PDO::PARAM_INT);
            $requete->bindParam(':id', $id, PDO::PARAM_INT);
            $requete->bindParam(':pourAlcool', $pourcentageAlcool, PDO::PARAM_INT);
        }

        return $requete->execute();
        
    }

    //Supprime un brassin
    public function supprimerBrassin($code) {

        $sql = "DELETE FROM mouvement WHERE code = :code; DELETE FROM brassin WHERE code = :code";

        $requete = $this->pdo->prepare($sql);
        $requete->bindParam(':code', $code, PDO::PARAM_STR);

        return $requete->execute();

    }
}

?>