<?php
require_once (File::build_path(array("model","Model.php")));

	class ModelReponseChamp extends Model{

		    private $idReponse;
      	private $idChamp;
      	private $valeurChamp;

      	protected static $object = "reponseChamp";
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
          if (!is_null($data['idReponse']) && !is_null($data['idChamp']) && !is_null($data['valeurChamp'])) {
          // Si aucun de $m, $c et $i sont nuls,
          // c'est forcement qu'on les a fournis
          // donc on retombe sur le constructeur à 3 arguments
            $this->idReponse = $data['idReponse'];
            $this->idChamp = $data['idChamp'];
            $this->valeurChamp = $data['valeurChamp'];
          }
        }

      	public static function selectByReponse($idReponse) {
        	$sql = "(SELECT c.idChamp , c.nomChamp ,c.contexte , c.contexteImage, c.instructionReponse, c.idFormulaire, c.typeChamp, c.valeurMaxChamp, c.idVariable, c.coefficient, r.idReponse, r.valeurChamp 
                  FROM VIZUIC2_reponseChamp r
                  RIGHT OUTER JOIN VIZUIC2_champ c ON c.idChamp = r.idChamp
                  WHERE idReponse IS NULL = TRUE AND idFormulaire = 14)
                  UNION
                  (SELECT c.idChamp , c.nomChamp ,c.contexte , c.contexteImage, c.instructionReponse, c.idFormulaire, c.typeChamp, c.valeurMaxChamp, c.idVariable, c.coefficient, r.idReponse, r.valeurChamp
                  FROM VIZUIC2_reponseChamp r
                  RIGHT OUTER JOIN VIZUIC2_champ c ON c.idChamp = r.idChamp
                  WHERE idReponse = 69 AND idFormulaire = 14)
                  ORDER BY idChamp ASC;";

        	$req_prep = Model::$pdo->prepare($sql);

        	$values = array("idReponse" => $idReponse);

        	$req_prep->execute($values);

        	$req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelReponseChamp");

       	 	$tab = $req_prep->fetchAll();
        
        	if (empty($tab)) {
          		return false;
        	}
        	return $tab;
      	}

        public static function update($data){
          
          $sql = "UPDATE VIZUIC2_reponseChamp SET valeurChamp = :valeurChamp
                  WHERE idReponse = :idReponse and idChamp = :idChamp";

          $req_prep = Model::$pdo->prepare($sql);

          $req_prep->execute($data);
        }
	}

?>