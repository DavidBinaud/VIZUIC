<?php

require_once(File::build_path(array("model", "Model.php")));
require(File::build_path(array("lib", "Security.php")));

class ModelUtilisateur extends Model{
	private $Identifiant;
	private $nomUtilisateur;
	private $motDePasse;
	private $email;
	private $est_Admin;

	protected static $object = "utilisateur";
  	protected static $primary = "Identifiant";


	public function __construct($data = null) {

      	if($data != null) {
        	foreach ($data as $key => $value) {
        		if (in_array($key, array_keys(get_object_vars($this)))) {
          			$this->$key = $data[$key];
          		}
        	}
      	}
	}

	public function get($var) {
		return $this->$var;
	}

	public static function checkPassword($Identifiant, $motDePasse) {

		$sql = "SELECT count(Identifiant) as nb FROM VIZUIC2_utilisateur WHERE Identifiant=:Identifiant AND motDePasse=:motDePasse";

		$req_prep = Model::$pdo->prepare($sql);

		$password_hash = Security::chiffrer($motDePasse);
		$req_prep->bindParam(":Identifiant", $Identifiant);
		$req_prep->bindParam(":motDePasse", $password_hash);
		//$req_prep->bindParam(":motDePasse", $motDePasse);

		$resultat = $req_prep->execute();
		$resultat = $req_prep->fetch();

		if($resultat["nb"] == 0) {
			return false;
		}
		else {
			$_SESSION["Identifiant"]=$Identifiant;
			return true;
		}
	}

}