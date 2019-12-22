<?php
require_once File::build_path(array("model", "ModelChamp.php")); // chargement du modèle
class ControllerChamp {
    protected static $object = "champ";

    public static function readAll() {
        
        $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);     //appel au modèle pour gerer la BD
        
        $controller='champ';
        $view='list';
        $pagetitle='Liste des questions';
        if (isset($_GET['gestion'])) {
            $gestion = $_GET['gestion'];
        } else {
            $gestion = 0;
        }
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function read() {
    	$q = ModelChamp::select($_GET['idChamp']);
        $controller='champ';
        $view='detail';
        $pagetitle='Detail du champ';
        if (isset($_GET['gestion'])) {
            $gestion = $_GET['gestion'];
        } else {
            $gestion = 0;
        }        
        require File::build_path(array("view", "view.php"));
    }

    public static function create() {
        $controller='champ';
        $view='update';
        $pagetitle='Création de champ';
    	require File::build_path(array("view", "view.php"));
    }

    public static function created() {
        $data = array('nomChamp' => $_GET['nomChamp'],
                      'idFormulaire' => $_GET['idFormulaire'],
                      'typeChamp' => $_GET['typeChamp']);
        
        if(isset($_GET['contexte'])){
            $data['contexte'] = $_GET['contexte'];
        }

        if(isset($_GET['contexteImage'])){
            $data['contexteImage'] = $_GET['contexteImage'];
        }

        if(isset($_GET['instructionReponse'])){
            $data['instructionReponse'] = $_GET['instructionReponse'];
        }

        if(isset($_GET['max'])){
            $data['valeurMaxChamp'] = $_GET['max'];
        }
        
    	if(ModelChamp::save($data) == false) {
            $controller='champ';
            $view='errorCreated';
            $pagetitle='Erreur lors de la création';
    	}
    	else {
            $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);
            $view='created';
            $pagetitle = 'Création réussie';
            $gestion = 1;
    	}

        require File::build_path(array("view", "view.php"));
    }

    public static function delete() {
        ModelChamp::delete($_GET['idChamp']);
        $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);     //appel au modèle pour gerer la BD
        $controller='champ';
        $view='deleted';
        $pagetitle='Question supprimée';
        $gestion = 1;
        require File::build_path(array("view", "view.php"));
    }

    public static function error() {
        $controller='champ';
        $view='errorAction';
        $pagetitle='Aucune action de ce type';
        require File::build_path(array("view", "view.php"));
    }

    public static function update() {
        $idChamp = $_GET['idChamp'];
        $tab_q = ModelChamp::select($idChamp);
        $controller='champ';
        $view='update';
        $pagetitle='Modification du champ';
        require File::build_path(array("view", "view.php"));
    }

    public static function updated() {
        if(isset($_GET['idChamp']) && isset($_GET['nomChamp']) && isset($_GET['idFormulaire']) && isset($_GET['typeChamp'])){

            $data = array('idChamp' => $_GET['idChamp'],
                          'nomChamp' => $_GET['nomChamp'],
                          'typeChamp' => $_GET['typeChamp'],
                          'idFormulaire' => $_GET['idFormulaire']
                      );

            if(isset($_GET['contexte'])){
                $data['contexte'] = $_GET['contexte'];
            }

            if(isset($_GET['contexteImage'])){
                $data['contexteImage'] = $_GET['contexteImage'];
            }

            if(isset($_GET['instructionReponse'])){
                $data['instructionReponse'] = $_GET['instructionReponse'];
            }

            if(isset($_GET['max'])){
                $data['valeurMaxChamp'] = $_GET['max'];
            }
            ModelChamp::update($data);
        }
        $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);
        $controller='champ';
        $view='updated';
        $pagetitle='modification';
        $gestion = 1;
        require File::build_path(array("view", "view.php"));
    }
}
?>