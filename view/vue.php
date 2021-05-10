<?php

class Vue {
	
	private function entete() {
		echo "
			<!DOCTYPE html>
			<html>
				<head>
					<meta charset='UTF-8'>
					<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

					<link rel=\"stylesheet\" href=\"css/bootstrap.min.css\">
					<link rel=\"stylesheet\" href=\"css/style.css\">

					<script src=\"js/jquery-3.5.1.min.js\"></script>
					<script src=\"js/bootstrap.min.js\"></script>

					<title>Brasserie</title>
				</head>
				<body>
				<nav class=\"navbar navbar-expand-lg navbar-dark bg-dark\">
					<a class=\"navbar-brand\" href=\"index.php\"><img src=\"./images/logo.png\" width=\"50px\" />Brasserie Clémence</a>
					<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
						<span class=\"navbar-toggler-icon\"></span>
					</button>
				
					<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
						<ul class=\"navbar-nav mr-auto\">
							
			";


			if(isset($_SESSION["connexion"])) {
				echo "

				<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=accueil\">
									Accueil
								</a>
							</li>
							
							
							<li class=\"nav-item dropdown\">
								<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
									Ajouter
								</a>
								<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
			
			
									<a class=\"dropdown-item\" href=\"index.php?action=ajoutBiere\">Bière</a>
									<a class=\"dropdown-item\" href=\"index.php?action=ajoutBrassin\">Brassin</a>
									<a class=\"dropdown-item\" href=\"index.php?action=ajoutMouvement\">Mouvement</a>

								</div>
							</li>
							<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=deconnexion\">Déconnexion</a>
							</li>
				";
			}
			else {
				echo "
							<li class=\"nav-item\">
								<a class=\"nav-link\" href=\"index.php?action=connexion\">Connexion</a>
							</li>
				";
			}	
		echo "
							
						</ul>
						</form>
					</div>
				</nav>
				<div id=\"content\">
		";
	}

	private function fin() {
		echo "
					</div>
					
				</body>
			</html>
		";
	}

	public function accueil($tableauBrassin, $tableauMouvement) {
		
		$this->entete();
		
		echo "
		<table class=\"table table-dark table-hover\">
			<tr>
				<th>Brassin</th>
				<th>Date brassage</th>
				<th>Nom commercial</th>
				<th>%alc</th>
				<th>Volume (Litres)</th>
				<th>Date de mise en bouteille</th>
				<th>Volume des entrées (L)</th>
				<th>Nombre d'entrées</th>
				<th>Volume effectif des entrées</th>
				<th>Éditer</th>
			</tr>
		";

		foreach($tableauBrassin as $ligne)
		{
			echo "
			<tr>
				<td>".$ligne["code"]."</td>
				<td>".$ligne["dateBrass"]."</td>
				<td>".$ligne["nom"]."</td>
				<td>".$ligne["pourAlcool"]."</td>
				<td>".$ligne["volume"]."</td>
				<td>".$ligne["dateMiseBout"]."</td>
				<td>".$ligne["contenance"]."</td>
				<td>".$ligne["COUNT(mouvement.contenance)"]."</td>
				<td>".($ligne["contenance"] * $ligne["COUNT(mouvement.contenance)"])."</td>
				<td><a href=\"index.php?action=editerTableau&code=".$ligne['code']."\"<button type=\"submit\" class=\"btn btn-outline-warning\">Éditer</button></a></td>
			</tr>
			";
		}

		echo "
		</table>
		<br />
		<table class=\"table table-dark\">
			<tr>
				<th>Date</th>
				<th>Nom commercial</th>
				<th>%alc</th>
				<th>Contenance (L)</th>
				<th>Stock début de mois</th>
				<th>Stock réalisé sur le mois</th>
				<th>Sorties vendues sur le mois</th>
				<th>Sorties dégustation/test/analyse</th>
				<th>Stock fin de mois</th>
				<th>Volume effectif des sorties</th>
				<th>Coût douanes</th>
				<th>Éditer</th>
			</tr>
		";

		foreach($tableauMouvement as $ligne)
		{
			echo "
			<tr>
				<td>".$ligne["date"]."</td>
				<td>".$ligne["nom"]."</td>
				<td>".$ligne["pourAlcool"]."</td>
				<td>".$ligne["contenance"]."</td>
				<td>".$ligne["stockDebMois"]."</td>
				<td>".$ligne["stockRealise"]."</td>
				<td>".$ligne["sortiesVendues"]."</td>
				<td>".$ligne["sortiesDeg"]."</td>
				<td>".$ligne["stockFinMois"]."</td>
				<td>".$ligne["volSorties"]."</td>
				<td>".$ligne["coutDouanes"]."</td>
				<td><a href=\"index.php?action=editerTableau&code=".$ligne['code']."\"<button type=\"submit\" class=\"btn btn-outline-warning\">Éditer</button></a></td>
			</tr>
			";
		}

		echo "
		</table>
		";

		$this->fin();
	}

	public function connexion($message = null) {
		$this->entete();

		echo "
			<form method='POST' action='index.php?action=connexion'>
				<h1>Se connecter :</h1>
				<br/>
				<div class=\"form-group\">
					<label for=\"text\">Login</label>
					<input type=\"text\" name=\"login\" class=\"form-control\" id=\"login\" required>
				</div>
				<div class=\"form-group\">
					<label for=\"motdepasse\">Mot de passe</label>
					<input type=\"password\" name=\"motdepasse\" class=\"form-control\" id=\"motdepasse\" placeholder=\"●●●●●●\" required>
				</div>
				<br/>
				<br/>
				<br/>
				<button type=\"submit\" class=\"btn btn-primary\" name=\"OkConnect\">Connexion</button>
			</form>
		";

		if(isset($message))
		{
			echo "
			<br />
			<div class=\"alert alert-warning\" role=\"alert\"><b>
				".$message."
		  	</b></div>";
		}

		$this->fin();
	}

	public function ajoutBiere($message = null) {
		$this->entete();

		echo "
			<center>
			<h1>Ajouter une bière</h1>
			<br />
			<br />

			<form action=\"\" method=\"POST\" name=\"ajouterBiere\">
				<p><b>Nom de la bière : </b><input type=\"text\" name=\"nomBiere\" /></p>
				<br />
				<input type=\"submit\" class=\"btn btn-primary\" name=\"ajouterUneBiere\" value=\"Valider\" />
			</form>
			</center>
		";

		if(isset($message))
		{
			echo "
			<br />
			<div class=\"alert alert-warning\" role=\"alert\"><b>
				".$message."
		  	</b></div>";
		}

		$this->fin();
	}

	public function ajoutMouvement($lesBrassins, $message = null) {
		$this->entete();

		echo "
			<center>
			<h1>Ajouter un mouvement</h1>
			<br />
			<br />

			<form action=\"\" method=\"POST\" name=\"ajouterMouvement\">
				<p><b>Brassin concerné : </b><select name=\"brassinMouvements\">
				";
					
				foreach($lesBrassins as $brassin)
				{
					echo "<option value='".$brassin["code"]."'>".$brassin["code"]."</option>";
				}

				echo "
				</select></p>
				<br />
				<p><b>Date du mouvement : </b><input type=\"date\" name=\"dateMouvement\" /></p>
				<br />
				<p><b>Nombre de bouteilles : </b><input type=\"text\" name=\"bouteillesMouvement\" /></p>
				<br />
				<p><b>Contenance des bouteilles (L) : </b><select name=\"contenanceMouvement\" />
				<option value=\"0.33\">0,33</option>
				<option value=\"0.75\">0,75</option>
				<option value=\"5\">5</option>
				<option value=\"20\">20</option>
				</select></p>
				<input type=\"submit\" class=\"btn btn-primary\" name=\"ajouterUnMouvement\" value=\"Valider\" />
			</form>
			</center>
		";

		if(isset($message))
		{
			echo "
			<br />
			<div class=\"alert alert-warning\" role=\"alert\"><b>
				".$message."
		  	</b></div>";
		}

		$this->fin();
	}

	public function ajoutBrassin($lesBieres, $message = null) {
		$this->entete();

		echo "
			<center>
			<h1>Ajouter un brassin</h1>
			<br />
			<br />

			<form action=\"\" method=\"POST\" name=\"ajouterBrassin\">
				<p><b>Bière produite : </b><select name=\"bieresBrassin\">
				";
					
				foreach($lesBieres as $biere)
				{
					echo "<option value='".$biere["id"]."'>".$biere["nom"]."</option>";
				}

				echo "
				</select></p>
				<br />
				<p><b>Date du brassin : </b><input type=\"date\" name=\"dateBrassin\" /></p>
				<br />
				<p><b>Volume : </b><input type=\"text\" name=\"volumeBrassin\" /></p>
				<input type=\"submit\" class=\"btn btn-primary\" name=\"ajouterUnBrassin\" value=\"Valider\" />
			</form>
			</center>
		";

		if(isset($message))
		{
			echo "
			<br />
			<div class=\"alert alert-warning\" role=\"alert\"><b>
				".$message."
		  	</b></div>";
		}

		$this->fin();
	}

	public function editerTableauBrassin($biere, $brassin, $mouvements) {

		$this->entete();

		echo "
		<h1>Bière : <span style=\"font-weight:normal\"><i>".$biere['nom']."</i></span></h1>
		<br />
		<br />
		<h2>Brassin :</h2>
		<table class=\"table table-dark\">
		<tr>
			<th>Code</th>
			<th>Date brassage</th>
			<th>Date mise en bouteille</th>
			<th>Volume (L)</th>
			<th>Pourcentage d'alcool</th>
			<th></th>
			<th></th>
		</tr>
		";


			echo "
			<tr>
				<td>".$brassin['code']."</td>
				<td>".$brassin['dateBrass']."</td>
				<td>".$brassin['dateMiseBout']."</td>
				<td>".$brassin['volume']."</td>
				<td>".$brassin['pourAlcool']."</td>
				<td><a href=\"index.php?action=modifierBrassin&code=".$brassin['code']."\"<button type=\"submit\" class=\"btn btn-outline-warning\">Modifier</button></a></td>
				<td><a href=\"index.php?action=supprimerBrassin&code=".$brassin['code']."\"<button type=\"submit\" class=\"btn btn-outline-warning\">Supprimer</button></a></td>
			<tr>
			";
			

		echo "
		</table>
		<br />
		<br />
		<h2>Mouvements :</h2>
		<table class=\"table table-dark\">
		<tr>
			<th>Date</th>
			<th>Contenance (L)</th>
			<th>Nombre bouteilles</th>
			<th>Stock début de mois</th>
			<th>Stock réalisé</th>
			<th>Sorties vendues</th>
			<th>Sorties dégustation</th>
			<th>Stock fin de mois</th>
			<th>Volume sorties (L)</th>
			<th>Coût des douanes</th>
			<th></th>
			<th></th>
		</tr>
		";

		foreach($mouvements as $mouvement) {

			echo "
			<tr>
				<td>".$mouvement['date']."</td>
				<td>".$mouvement['contenance']."</td>
				<td>".$mouvement['nbBouteilles']."</td>
				<td>".$mouvement['stockDebMois']."</td>
				<td>".$mouvement['stockRealise']."</td>
				<td>".$mouvement['sortiesVendues']."</td>
				<td>".$mouvement['sortiesDeg']."</td>
				<td>".$mouvement['stockFinMois']."</td>
				<td>".$mouvement['volSorties']."</td>
				<td>".$mouvement['coutDouanes']."</td>
				<td><a href=\"index.php?action=modifierMouvement&id=".$mouvement['id']."\"<button type=\"submit\" class=\"btn btn-outline-warning\">Modifier</button></a></td>
				<td><a href=\"index.php?action=supprimerMouvement&id=".$mouvement['id']."\"<button type=\"submit\" class=\"btn btn-outline-warning\">Supprimer</button></a></td>
			<tr>
			";
			
		}

		echo "</table>";

		$this->fin();
	}

	public function modifierBrassin() {

	}

	public function modifierMouvement() {
		
	}

	public function brassinSupprime() {

		$this->entete();

		echo "<h2>Brassin supprimé avec l'intégralité des mouvements associés</h2>
		<br />
		<p><a href=\"index.php?action=accueil\">Cliquez ici pour retourner à l'accueil</a></p>";

		$this->fin();

	}

	public function mouvementSupprime() {

		$this->entete();

		echo "<h2>Mouvement supprimé avec succès</h2>
		<br />
		<p><a href=\"index.php?action=accueil\">Cliquez ici pour retourner à l'accueil</a></p>";

		$this->fin();

	}

	public function erreur404() {
		http_response_code(404);

		$this->entete();

		echo "
			<h1>Erreur 404 : page introuvable !</h1>
			<br/>
			<p>
				Cette page n'existe pas ou a été supprimée !
			</p>
		";

		$this->fin();
	}

}