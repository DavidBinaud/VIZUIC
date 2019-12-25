<?php
require_once File::build_path(array("model", "ModelChamp.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelVariable.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelFormulaire.php")); // chargement du modèle
class ControllerChamp {
    protected static $object = "champ";

    public static function readAll() {

        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);

        if (Session::is_admin() | strcmp($formulaire->get('idCreateur'),$_SESSION['Identifiant'])==1) {
            $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);     //appel au modèle pour gerer la BD
            $controller='champ';
            $view='list';
            $pagetitle='Liste des questions';
            if (isset($_GET['gestion'])) {
                $gestion = $_GET['gestion'];
            } else {
            $gestion = 0;
            }
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='champ';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        
        
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    /*public static function read() {
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
    }*/

    public static function create() {
        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);
        if (Session::is_user() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $tab_variable = ModelVariable::selectByForm($_GET["idFormulaire"]);
            $controller='champ';
            $view='update';
            $pagetitle='Création de champ';
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='champ';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
    	require File::build_path(array("view", "view.php"));
    }

    public static function created() {
        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);
        if (Session::is_user() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
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

            if (isset($_GET['idVariable'])) {
                $data['idVariable'] = $_GET['idVariable'];
            }
            if (isset($_GET['coefficient'])) {
                $data['coefficient'] = $_GET['coefficient'];
            }
        
    	    if(ModelChamp::save($data) == false) {
                $controller='champ';
                $view='error';
                $errorType='Erreur lors de la création';
                $pagetitle='Erreur création';
                if (Session::is_admin()) {
                    $tab_q = ModelFormulaire::selectAll();
                } else {
                    $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
                }
            
    	    } else {
                $view='created';
                $pagetitle = 'Création réussie';
                $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);
                $gestion = 1;
    	   }
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='champ';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }

        require File::build_path(array("view", "view.php"));
    }

    public static function delete() {
        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);
        if (Session::is_admin()) {
            ModelChamp::delete($_GET['idChamp']);
            $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);     //appel au modèle pour gerer la BD
            $controller='champ';
            $view='deleted';
            $pagetitle='Question supprimée';
            $gestion = 1;
        } else {
            if (strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
                ModelChamp::delete($_GET['idChamp']);
                $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);     //appel au modèle pour gerer la BD
                $controller='champ';
                $view='deleted';
                $pagetitle='Question supprimée';
                $gestion = 1;
            } else {
                $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
                $controller='champ';
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
        $controller='champ';
        $view='error';
        $errorType='Aucune action de ce type';
        $pagetitle='Erreur action';
        require File::build_path(array("view", "view.php"));
    }

    public static function update() {
        $idChamp = $_GET['idChamp'];
        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $tab_q = ModelChamp::select($idChamp);
            $tab_variable = ModelVariable::selectByForm($_GET["idFormulaire"]);
            $controller='champ';
            $view='update';
            $pagetitle='Modification du champ';
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='champ';
            $view='error';
            $pagetitle='Erreur droits';
            $errorType='Vous n\'avez pas les droits';
        }
        require File::build_path(array("view", "view.php"));
    }

    public static function updated() {
        $formulaire = ModelFormulaire::select($_GET['idFormulaire']);
        if (Session::is_user() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
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

                if (isset($_GET['idVariable'])) {
                    $data['idVariable'] = $_GET['idVariable'];
                }
                if (isset($_GET['coefficient'])) {
                    $data['coefficient'] = $_GET['coefficient'];
                }
                ModelChamp::update($data);
            }
            $tab_q = ModelChamp::selectByForm($_GET['idFormulaire']);
            $controller='champ';
            $view='updated';
            $pagetitle='modification';
            $gestion = 1;
        } else {
            $tab_q = ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='champ';
            $view='error';
            $pagetitle='Erreur droits';
            $errorType='Vous n\'avez pas les droits';
        }
        require File::build_path(array("view", "view.php"));
    }
}
?>