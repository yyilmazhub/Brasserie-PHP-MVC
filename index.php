<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//TEST DE CONNEXION A LA BASE
$config = parse_ini_file("config.ini");
try {
	$pdo = new \PDO("mysql:host=".$config["host"].";dbname=".$config["database"].";charset=utf8", $config["user"], $config["password"]);
}
catch(Exception $e) {
	echo "<h1>Erreur de connexion à la base de données :</h1>";
	echo $e->getMessage();
	exit;
}

//CHARGEMENT DES MODEL
require("./control/controleur.php");
require("./view/vue.php");
require("./model/biere.php");
require("./model/brassin.php");
require("./model/mouvement.php");
require("./model/user.php");

//ROUTES

//Si une action est envoyée
if(isset($_SESSION["connexion"]))
{
	if(isset($_GET["action"])) {
		switch($_GET["action"]) {
			case "accueil":
				(new Controleur)->accueil();
				break;
	
			case "ajoutBiere":
				(new Controleur)->ajoutBiere();
				break;
			
			case "ajoutMouvement":
				(new Controleur)->ajoutMouvement();
				break;
	
			case "ajoutBrassin":
				(new Controleur)->ajoutBrassin();
				break;
	
			case "deconnexion":
				(new Controleur)->deconnexion();
				break;

			case "editerTableau":
				(new Controleur)->editerTableau();
				break;

			case "modifierBrassin":
				(new Controleur)->modifierBrassin();
				break;
			
			case "supprimerBrassin":
				(new Controleur)->supprimerBrassin();
				break;

			case "modifierMouvement":
				(new Controleur)->modifierMouvement();
				break;

			case "supprimerMouvement":
				(new Controleur)->supprimerMouvement();
				break;

			//Route par défaut si l'action de correspond pas
			default:
				(new Controleur)->erreur404();
				break;
		}
	}
	else {
		//Si pas d'action précise -> on retourne à l'accueil
			(new Controleur)->accueil();	
	}
}
else
{
	(new Controleur)->connexion();
}


?>