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



     public static function selectAll($idFormulaire) {

            $sql = "SELECT R.idReponse,RV.idVariable,RV.valeurVariable from VIZUIC2_formulaire F
                    JOIN VIZUIC2_reponse R ON F.idFormulaire = R.idFormulaire
                    JOIN VIZUIC2_reponseVariable RV ON R.idReponse = RV.idReponse
                    JOIN VIZUIC2_variable V ON RV.idVariable = V.idVariable
                    WHERE F.idFormulaire=:idForm";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "idForm" => $idFormulaire
            );

            // On donne les valeurs et on exécute la requête   
            $req_prep->execute($values);
            
            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_ASSOC);
            $tab = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab))
                return false;
            return $tab;
        }





    public static function select($idFormulaire,$idReponse) {

            $sql = "SELECT RV.idVariable,V.nomVariable,RV.valeurVariable from VIZUIC2_formulaire F
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
            $req_prep->setFetchMode(PDO::FETCH_ASSOC);
            $tab = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab))
                return false;
            return $tab;
    }


    public static function selectVariablesInfos($idFormulaire){
         $sql = "SELECT V.idVariable,V.nomVariable from 
                VIZUIC2_variable V
                WHERE V.idFormulaire=:idForm";
            // Préparation de la requête
            $req_prep = Model::$pdo->prepare($sql);

            $values = array(
                "idForm" => $idFormulaire
            );

            // On donne les valeurs et on exécute la requête   
            $req_prep->execute($values);
            
            // On récupère les résultats comme précédemment
            $req_prep->setFetchMode(PDO::FETCH_ASSOC);
            $tab = $req_prep->fetchAll();
            // Attention, si il n'y a pas de résultats, on renvoie false
            if (empty($tab))
                return false;
            return $tab;
    }   



    public static function selectReponsesInfos($idFormulaire){
        $sql = "SELECT R.idReponse,R.nomReponse from 
                VIZUIC2_reponse R
                WHERE R.idFormulaire=:idForm";

        // Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);

        $values = array(
            "idForm" => $idFormulaire
        );

        // On donne les valeurs et on exécute la requête   
        $req_prep->execute($values);
        
        // On récupère les résultats comme précédemment
        $req_prep->setFetchMode(PDO::FETCH_ASSOC);
        $tab = $req_prep->fetchAll();
        // Attention, si il n'y a pas de résultats, on renvoie false
        if (empty($tab))
            return false;
        return $tab;
    }   

        
}

 

?>