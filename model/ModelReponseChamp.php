<?php
require_once (File::build_path(array("model","Model.php")));

	class ModelVariable extends Model{

		private $idVariable;
      	private $nomVariable;
      	private $idFormulaire;

      	protected static $object = "variable";
      	protected static $primary = "idVariable";
          
      	//getter générique
      	public function get($label_attribut){
      		return $this->$label_attribut;
      	}

      	//setter générique
      	public function set($label_attribut,$value){
        	$this->$label_attribut = $value;
      	}

      	// un constructeur
      	// La syntaxe ... = NULL signifie que l'argument est optionel
      	// Si un argument optionnel n'est pas fourni,
      	//   alors il prend la valeur par défaut, NULL dans notre cas
      	public function __construct($data = NULL) {
          if (!is_null($data['idVariable']) && !is_null($data['nomVariable']) && !is_null($data['idFormulaire'])) {
          // Si aucun de $m, $c et $i sont nuls,
          // c'est forcement qu'on les a fournis
          // donc on retombe sur le constructeur à 3 arguments
            $this->idVariable = $data['idVariable'];
            $this->nomVariable = $data['nomVariable'];
            $this->idFormulaire = $data['idFormulaire'];
          }
        }

      	public static function selectByForm($idFormulaire) {
        	$sql = "SELECT * FROM VIZUIC2_variable WHERE idFormulaire = :idFormulaire";

        	$req_prep = Model::$pdo->prepare($sql);

        	$values = array("idFormulaire" => $idFormulaire);

        	$req_prep->execute($values);

        	$req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelVariable");

       	 	$tab = $req_prep->fetchAll();
        
        	if (empty($tab)) {
          		return false;
        	}
        	return $tab;
      	}
	}

?>