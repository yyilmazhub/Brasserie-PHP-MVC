<?php

class Controleur {

    public function accueil() {

        $tableauBrassin = (new Mouvement)->afficherTableauBrassin();
        $tableauMouvement = (new Mouvement)->afficherTableauMouvement();
        
        (new Vue)->accueil($tableauBrassin, $tableauMouvement);
    }

    public function connexion() {

        if(isset($_POST["OkConnect"]))
        {
            if(isset($_POST["login"]) && isset($_POST["motdepasse"]))
            {
                $connexion = (new User)->connexion($_POST["login"], $_POST["motdepasse"]);

                if($connexion)
                {
                    $tableauBrassin = (new Mouvement)->afficherTableauBrassin();
                    $tableauMouvement = (new Mouvement)->afficherTableauMouvement();

                    (new Vue)->accueil($tableauBrassin, $tableauMouvement);
                }
                else
                {
                    $message = "Login ou mot de passe incorrect";
                    (new Vue)->connexion($message);
                }
            }
            else
            {
                $message = "Veuillez remplir les champs obligatoires";
                (new Vue)->connexion($message);
            }
        }
        else
        {
            (new Vue)->connexion();
        } 
    }

    public function deconnexion() {

        session_unset();
        (new Vue)->connexion();

    }

    public function ajoutBiere() {

        if(isset($_POST["ajouterUneBiere"]))
        {
            $biere = (new Biere)->creerBiere($_POST['nomBiere']);

            if($biere)
            {
                $message = "Bière ajoutée avec succès";
                (new Vue)->ajoutBiere($message);
            }
            else
            {
                $message = "Une erreur est survenue";
                (new Vue)->ajoutBiere($message);
            }
        }
        else
        {
            (new Vue)->ajoutBiere();
        }
    }

    public function ajoutBrassin() {

        $lesBieres = (new Biere)->getAllBiere();

        if(isset($_POST["ajouterUnBrassin"]))
        {
            if(isset($_POST["bieresBrassin"]) && isset($_POST["dateBrassin"]) && isset($_POST["volumeBrassin"]))
            {
                $brassin = (new Brassin);
                $code = $brassin->creerIDBrassin($_POST["dateBrassin"]);
                $brassin->ajoutBrassin($code, $_POST["dateBrassin"], $_POST["volumeBrassin"], $_POST["bieresBrassin"]);

                if($brassin)
                {
                    $message = "Brassin ajouté avec succès";
                    (new Vue)->ajoutBrassin($lesBieres, $message);
                }
                else
                {
                    $message = "Une erreur est survenue";
                    (new Vue)->ajoutBrassin($lesBieres, $message);
                }
            }
            else
            {
                $message = "Veuillez remplir tout les champs";
                (new Vue)->ajoutBrassin($lesBieres, $message);
            }
        }
        else
        {
            (new Vue)->ajoutBrassin($lesBieres);
        }
    }

    public function ajoutMouvement() {

        $lesBrassins = (new Brassin)->getAllBrassin();

        if(isset($_POST["ajouterUnMouvement"]))
        {
            if(isset($_POST["dateMouvement"]) && isset($_POST["bouteillesMouvement"]) && isset($_POST["contenanceMouvement"]))
            {
                $mouvement = (new Mouvement)->ajoutMouvement($_POST["dateMouvement"], $_POST["contenanceMouvement"], $_POST["bouteillesMouvement"], $_POST["brassinMouvements"]);

                if($mouvement)
                {
                    $message = "Mouvement ajouté avec succès";
                    (new Vue)->ajoutMouvement($lesBrassins, $message);
                }
                else
                {
                    $message = "Une erreur est survenue";
                    (new Vue)->ajoutMouvement($lesBrassins, $message);
                }
            }
            else
            {
                $message = "Veuillez remplir tout les champs";
                (new Vue)->ajoutMouvement($lesBrassins, $message);
            }
        }
        else
        {
            (new Vue)->ajoutMouvement($lesBrassins);
        }
    }

    public function editerTableau() {

        if(isset($_GET['code']))
        {
            $brassin = (new Brassin)->getInfosBrassin($_GET['code']);
            $biere = (new Biere)->getBiereParBrassin($_GET['code']);
            $mouvements = (new Mouvement)->getMouvementParBrassin($_GET['code']);

            (new Vue)->editerTableauBrassin($biere, $brassin, $mouvements);
        }
        else
        {
            (new Vue)->erreur404();
        }
        
    }

    public function modifierBrassin() {

    }

    public function supprimerBrassin() {

        if(isset($_GET['code']))
        {
            $brassin = (new Brassin)->supprimerBrassin($_GET['code']);

            if($brassin)
            {
                (new Vue)->brassinSupprime();
            }
            else
            {
                (new Vue)->erreur404();
            }
        }
        else
        {
            (new Vue)->erreur404();
        }

    }

    public function modifierMouvement() {

    }

    public function supprimerMouvement() {
        
        if(isset($_GET["id"]))
        {
            $mouvement = (new Mouvement)->supprimerMouvement($_GET["id"]);

            if($mouvement)
            {
                (new Vue)->mouvementSupprime();
            }
            else
            {
                (new Vue)->erreur404();
            }
        }
    }

    public function erreur404() {
		(new Vue)->erreur404();
	}
}

?>