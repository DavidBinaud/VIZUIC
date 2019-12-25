<?php
require_once File::build_path(array("model", "ModelFormulaire.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelVariable.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelChamp.php")); // chargement du modèle
require_once File::build_path(array("lib", "Session.php")); // chargement des fonctions de session


class ControllerFormulaire {
    protected static $object = "formulaire";

    public static function readAll() {
        if (Session::is_admin()) {
            $tab_q = ModelFormulaire::selectAll();     //appel au modèle pour gerer la BD
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
        }
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
            if (Session::is_admin()) {
                $tab_q = ModelFormulaire::selectAll();
            } else {
                $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            }
            $controller='formulaire';
            $view='error';
            $pagetitle='Erreur création';
            $errorType='Erreur lors de la création';
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
            $tab_q = ModelChamp::selectByForm($idFormulaire);
            $view='created';
            $pagetitle = 'Création réussie';
            $gestion = 1;
            
    	}
        require File::build_path(array("view", "view.php"));
    }

    public static function delete() {
        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);
        if (Session::is_admin()) {
            ModelFormulaire::delete($_GET['idFormulaire']);
            $tab_q = ModelFormulaire::selectAll();
            $controller='formulaire';
            $view='deleted';
            $pagetitle='Questionnaire supprimé';
            $gestion = 1;
        } else {
            if (strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
                ModelFormulaire::delete($_GET['idFormulaire']);
                $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
                $controller='formulaire';
                $view='deleted';
                $pagetitle='Questionnaire supprimé';
            } else {
                $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
                $controller='formulaire';
                $view='error';
                $pagetitle='Erreur droits';
                $errorType='Vous n\'avez pas les droits';

            }
        }
        
        
        require File::build_path(array("view", "view.php"));
    }

    public static function error() {
        if (Session::is_admin()) {
            $tab_q = ModelFormulaire::selectAll();
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
        }
        $controller='formulaire';
        $view='error';
        $errorType='Aucune action de ce type';
        $pagetitle='Erreur action';
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
        
        $tab_q = ModelChamp::selectByForm($idFormulaire);
        $gestion = 1;
        $controller='formulaire';
        $view='updated';
        $pagetitle='modification';
        require File::build_path(array("view", "view.php"));
    }

}
?>