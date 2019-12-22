<?php
require_once File::build_path(array("model", "ModelFormulaire.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelVariable.php")); // chargement du modèle


class ControllerFormulaire {
    protected static $object = "formulaire";

    public static function readAll() {
        $tab_q = ModelFormulaire::selectAll();     //appel au modèle pour gerer la BD
        $controller='formulaire';
        $view='list';
        $pagetitle='Liste des formulaires';
        if (isset($_GET['gestion'])) {
            $gestion = $_GET['gestion'];
        } else {
            $gestion = 0;
        }
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    /*public static function read() {
    	$q = ModelFormulaire::select($_GET['idFormulaire']);
        $controller='formulaire';
        $view='detail';
        $pagetitle='Detail du formulaire';
        if (isset($_GET['gestion'])) {
            $gestion = $_GET['gestion'];
        } else {
            $gestion = 0;
        }
        
        require File::build_path(array("view", "view.php"));
    }*/

    public static function create() {
        $controller='formulaire';
        $view='update';
        $pagetitle='Création de formulaire';
    	require File::build_path(array("view", "view.php"));
    }

    public static function created() {
    	$data = array('nomFormulaire' => $_GET['nomFormulaire'],
                        'descriptionFormulaire' => $_GET['descriptionFormulaire'],
                        'idCreateur' => $_SESSION['Identifiant']);
        
    	if(ModelFormulaire::save($data) == false) {
            $controller='formulaire';
            $view='errorCreated';
            $pagetitle='Erreur lors de la création';
    	} else {
            $tab_v = explode(";", $_GET['variable']);
            $idFormulaire = ModelFormulaire::getLastCreated();
            foreach ($tab_v as $v) {
                $nomVariable = $v;
                if ($v != "") {
                    $data2 = array('nomVariable' => $v,
                                'idFormulaire' => $idFormulaire,);
                    ModelVariable::save($data2);
                }
                
                
             }
            $tab_q = ModelFormulaire::selectAll();
            $view='created';
            $pagetitle = 'Création réussie';
            $gestion = 1;
    	}
        require File::build_path(array("view", "view.php"));
    }

    public static function delete() {
        ModelFormulaire::delete($_GET['idFormulaire']);
        $tab_q = ModelFormulaire::selectAll();
        $controller='formulaire';
        $view='deleted';
        $pagetitle='Questionnaire supprimé';
        $gestion = 1;
        require File::build_path(array("view", "view.php"));
    }

    public static function error() {
        $controller='formulaire';
        $view='errorAction';
        $pagetitle='Aucune action de ce type';
        require File::build_path(array("view", "view.php"));
    }

    public static function update() {
        $idFormulaire = $_GET['idFormulaire'];
        $tab_q = ModelFormulaire::select($idFormulaire);
        $tab_variable = ModelVariable::selectByForm($idFormulaire);
        $controller='formulaire';
        $view='update';
        $pagetitle='Modification du formulaire';
        require File::build_path(array("view", "view.php"));
    }

    public static function updated() {
        $idFormulaire = $_GET['idFormulaire'];
        $data = array('idFormulaire' => $idFormulaire,
                        'nomFormulaire' => $_GET['nomFormulaire'],
                        'descriptionFormulaire' => $_GET['descriptionFormulaire'],
                        'idCreateur' => $_SESSION['Identifiant']);
        ModelFormulaire::update($data);

        $tab_v = explode(";", $_GET['variable']);
        $str_id = $_GET['idVariable'];
        $cpt=0;
        $tab_id = explode(";" , $str_id);

        foreach ($tab_v as $v) {
            $nomVariable = $v;
            if ($nomVariable != "") {
                if($tab_id[$cpt] != ""){
                    $data2 = array('idVariable' => intval($tab_id[$cpt++]),
                                'nomVariable' => $v,
                                'idFormulaire' => $idFormulaire,);
                    ModelVariable::update($data2);
                }else{
                    $data2 = array('nomVariable' => $v,
                                'idFormulaire' => $idFormulaire,);
                    ModelVariable::save($data2);
                }
            }
        } 
        while ($tab_id[$cpt] != ""){
            $idVariable = intval($tab_id[$cpt++]);
            ModelVariable::delete($idVariable);
        }     
        
        $tab_q = ModelFormulaire::selectAll();
        $gestion = 1;
        $controller='formulaire';
        $view='updated';
        $pagetitle='modification';
        require File::build_path(array("view", "view.php"));
    }

}
?>