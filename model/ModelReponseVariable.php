<?php
require_once (File::build_path(array("model","Model.php")));

	class ModelReponseVariable extends Model{

      	private $idReponse;
		    private $idVariable;
      	private $valeurVariable;

      	protected static $object = "reponseVariable";
      	protected static $primary = "idReponse";
          
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
          if (!is_null($data['idReponse']) && !is_null($data['idVariable']) && !is_null($data['valeurVariable'])) {
          // Si aucun de $m, $c et $i sont nuls,
          // c'est forcement qu'on les a fournis
          // donc on retombe sur le constructeur à 3 arguments
            $this->idReponse = $data['idReponse'];
            $this->idVariable = $data['idVariable'];
            $this->valeurVariable = $data['valeurVariable'];
          }
        }

      	public static function selectByReponse($idReponse) {
        	$sql = "SELECT * FROM VIZUIC2_reponseVariable WHERE idReponse = :idReponse";

        	$req_prep = Model::$pdo->prepare($sql);

        	$values = array("idReponse" => $idReponse);

        	$req_prep->execute($values);

        	$req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelReponseVariable");

       	 	$tab = $req_prep->fetchAll();
        
        	if (empty($tab)) {
          		return false;
        	}
        	return $tab;
      	}

        public static function update($data){
          
          $sql = "UPDATE VIZUIC2_reponseVariable SET valeurVariable = :valeurVariable
                  WHERE idReponse = :idReponse and idVariable = :idVariable";

          $req_prep = Model::$pdo->prepare($sql);

          $req_prep->execute($data);
        }
	}

?>