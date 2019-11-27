<?php
require_once File::build_path(array("model", "Model.php"));
  class ModelChamp extends Model {
     
      private $idChamp;
      private $nomChamp;
      private $contexte;
      private $contexteImage;
      private $instructionReponse;
      private $idFormulaire;
      private $typeChamp;
      private $valeurMaxChamp;
      private $idVariable;
      private $coefficient;

      protected static $object = "champ";
      protected static $primary = "idChamp";
          
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
        if (!is_null($data['nomChamp']) && !is_null($data['idChamp']) && !is_null($data['idFormulaire']) && !is_null($data['typeChamp'])) {
          // Si aucun de $m, $c et $i sont nuls,
          // c'est forcement qu'on les a fournis
          // donc on retombe sur le constructeur à 3 arguments
          $this->nomChamp = $data['nomChamp'];
          $this->idChamp = $data['idChamp'];
          $this->idFormulaire = $data['idFormulaire'];
          $this->typeChamp = $data['typeChamp'];

        }

        if(!is_null($data['nomChamp'])){
          $this->contexteImage = $data['contexteImage'];
        }

        if(!is_null($data['instructionReponse'])){
          $this->instructionReponse = $data['instructionReponse'];
        }

        if(!is_null($data['contexte'])){
          $this->contexte = $data['contexte'];
        }

        if(!is_null($data['valeurMaxChamp'])){
          $this->valeurMaxChamp = $data['valeurMaxChamp'];
        }

        if(!is_null($data['idVariable'])){
          $this->idVariable = $data['idVariable'];
        }

        if(!is_null($data['coefficient'])){
          $this->coefficient = $data['coefficient'];
        }
      }
      
  }
?>