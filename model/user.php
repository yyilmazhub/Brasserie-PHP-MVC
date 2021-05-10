<?php

class User {

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

    public function connexion($login, $passwd) {

		$sql = "SELECT id, mdp FROM user WHERE log = :userLog";
		
		$req = $this->pdo->prepare($sql);
		$req->bindParam(':userLog', $login, PDO::PARAM_STR);
		$req->execute();
		
		$ligne = $req->fetch();

		if($ligne != false) {
			// Client existant
			
			// On vérifie si le hash du mot de passe stocké dans la base correspond au mot de passe saisi dans le formulaire
			if($passwd == $ligne["mdp"]) {
				// Connexion vérifiée
				$_SESSION["connexion"] = $ligne["id"];
				return true;
			}
			else {
				// Mot de passe incorrect
				return false;
			}
		}
		else {
			// Client inconnu
			return false;
		}
	}
}

?>