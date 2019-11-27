<?php
 class ModelVisualisation{
           
    private $data;
              
    //getter générique
    public function get($nom_attribut){
      return $this->$nom_attribut;
    }

    //setter générique
    public function set($nom_attribut,$value){
      $this->$nom_attribut = $value;
    }

    // un constructeur
    // La syntaxe ... = NULL signifie que l'argument est optionel
    // Si un argument optionnel n'est pas fourni,
    //   alors il prend la valeur par défaut, NULL dans notre cas
    public function __construct($data = NULL) {
        $this->data = $data;
    }


    public function get_object_vars() {
        return get_object_vars($this);
    }



    public static function selectAll(){
        $rep = Model::$pdo->query("SELECT * FROM VIZUIC_champ");

        $rep->setFetchMode(PDO::FETCH_CLASS, "ModelChamp");

        return  $rep->fetchAll();
    }





     public static function select($idFormulaire,$idReponse) {

            $sql = "SELECT * from VIZUIC2_formulaire F
                    JOIN VIZUIC2_reponse R ON F.idFormulaire = R.idFormulaire
                    JOIN VIZUIC2_reponseVariable RV ON R.idReponse = RV.idReponse
                    JOIN VIZUIC2_variable V ON RV.idVariable = V.idVariable
                    WHERE F.idFormulaire=:idForm AND R.idReponse=:idRep";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "idForm" => $idFormulaire,
                "idRep" => $idReponse
            );

            // On donne les valeurs et on exécute la requête   
            $req_prep->execute($values);
            
            // On récupère les résultats comme précédemment
            //$req_prep->setFetchMode(PDO::FETCH_ASSOC);
            $tab = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab))
                return false;
            return $tab;
        }



        public static function delete($primary){
            $sql = "DELETE FROM VIZUIC_champ WHERE id=:primary;
            ALTER TABLE VIZUIC_donnees DROP :nom";

            $req_prep = Model::$pdo->prepare($sql);

            $value = array(
                'primary' => $primary,
                'nom' => $this->nom,
            );    
      
      
            $req_prep->execute($values);
        }


    public static function save($data){
            try{
			$sql = "INSERT INTO VIZUIC_champ(nom,type) VALUES (:nom,:type)";
			$sql2= "ALTER TABLE VIZUIC_donnee ADD :nom :type";
		
		    $req_prep = Model::$pdo->prepare($sql);
            
			
            $values = $data->get_object_vars(); 

			if ($values['type'] == "text") {
				$values['type'] = "VARCHAR(50)";
			}
  	         var_dump($req_prep);
             var_dump($values);
	      	
	      	
	      	  $req_prep->execute($values);
              $req_prep2 = Model::$pdo->prepare($sql2);
              $req_prep2->execute($values);
 			}catch(PDOException $e) {
	      	    if($e->getCode() == 23000){
	      	    	return false;
	      	    }
		    }
      		return true;
    }
        
}

 

?>