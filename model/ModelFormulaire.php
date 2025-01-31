<?php
require_once File::build_path(array("model", "Model.php"));
  class ModelFormulaire extends Model {
     
      private $idFormulaire;
      private $nomFormulaire;
      private $descriptionFormulaire;
      private $idCreateur;

      protected static $object = "formulaire";
      protected static $primary = "idFormulaire";
          
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
        if (!is_null($data['idFormulaire']) && !is_null($data['nomFormulaire']) && !is_null($data['descriptionFormulaire']) && !is_null($data['idCreateur'])) {
          // Si aucun de $m, $c et $i sont nuls,
          // c'est forcement qu'on les a fournis
          // donc on retombe sur le constructeur à 3 arguments
          $this->idFormulaire = $data['idFormulaire'];
          $this->nomFormulaire = $data['nomFormulaire'];
          $this->descriptionFormulaire = $data['descriptionFormulaire'];
          $this->idFormulaire = $data['idCreateur'];
        }
      }

      public static function selectAllByUser($idCreateur){
        $sql = "SELECT * FROM VIZUIC2_formulaire
                WHERE idCreateur = :idCreateur";

        $req_prep = Model::$pdo->prepare($sql);

        $value = array('idCreateur' => $idCreateur, );

        $req_prep->execute($value);

        $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelFormulaire");

        $tab = $req_prep->fetchAll();
        
        if (empty($tab)) {
          return false;
        }
        return $tab;
      }

      public static function getLastCreated() {

          $sql = Model::$pdo->query("SELECT MAX(idFormulaire) FROM VIZUIC2_formulaire"); 

          $sql->setFetchMode(PDO::FETCH_NUM);

          $tab_j = $sql->fetchAll();
          
          return $tab_j[0][0];
      }
  }
?>