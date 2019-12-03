<?php
require_once File::build_path(array("model", "Model.php"));
  class ModelReponse extends Model {
     
      private $idReponse;
      private $nomReponse;
      private $idFormulaire;

      protected static $object = "reponse";
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
        if (!is_null($data['idReponse']) && !is_null($data['nomReponse']) && !is_null($data['idFormulaire'])) {
          // Si aucun de $m, $c et $i sont nuls,
          // c'est forcement qu'on les a fournis
          // donc on retombe sur le constructeur à 3 arguments
          $this->idReponse = $data['idReponse'];
          $this->nomReponse = $data['nomReponse'];
          $this->idFormulaire = $data['idFormulaire'];
        }
      }
  }
?>