<?php
require_once File::build_path(array("model", "ModelChamp.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelVariable.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelFormulaire.php")); // chargement du modèle
class ControllerChamp {
    protected static $object = "champ";

    public static function readAll() {

        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));

        if (Session::is_admin() | strcmp($formulaire->get('idCreateur'),$_SESSION['Identifiant'])==1) {
            $tab_q = ModelChamp::selectByForm(myGet('idFormulaire'));     //appel au modèle pour gerer la BD
            $controller='champ';
            $view='list';
            $pagetitle='Liste des questions';
            if (!is_null(myGet('gestion'))) {
                $gestion = myGet('gestion');
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
    	$q = ModelChamp::select(myGet('idChamp'));
        $controller='champ';
        $view='detail';
        $pagetitle='Detail du champ';
        if (!is_null(myGet('gestion'))) {
            $gestion = myGet('gestion');
        } else {
            $gestion = 0;
        }        
        require File::build_path(array("view", "view.php"));
    }*/

    public static function create() {
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $tab_variable = ModelVariable::selectByForm(myGet("idFormulaire"));
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
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $data = array('nomChamp' => myGet('nomChamp'),
                      'idFormulaire' => myGet('idFormulaire'),
                      'typeChamp' => myGet('typeChamp'));
        
            if(!is_null(myGet('contexte'))){
                $data['contexte'] = myGet('contexte');
            }

            if(!is_null(myGet('contexteImage'))){
                $data['contexteImage'] = myGet('contexteImage');
            }

            if(!is_null(myGet('instructionReponse'))){
                $data['instructionReponse'] = myGet('instructionReponse');
            }

            if(!is_null(myGet('max'))){
                $data['valeurMaxChamp'] = myGet('max');
            }

            if (!is_null(myGet('idVariable'))) {
                $data['idVariable'] = myGet('idVariable');
            }
            if (!is_null(myGet('coefficient'))) {
                $data['coefficient'] = myGet('coefficient');
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
                $idFormulaire = myGet('idFormulaire');
                $view='created';
                $pagetitle = 'Création réussie';
                $tab_q = ModelChamp::selectByForm(myGet('idFormulaire'));
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
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin()) {
            ModelChamp::delete(myGet('idChamp'));
            $idFormulaire = myGet('idFormulaire');
            $tab_q = ModelChamp::selectByForm(myGet('idFormulaire'));     //appel au modèle pour gerer la BD
            $controller='champ';
            $view='deleted';
            $pagetitle='Question supprimée';
            $gestion = 1;
        } else {
            if (strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
                ModelChamp::delete(myGet('idChamp'));
                $idFormulaire = myGet('idFormulaire');
                $tab_q = ModelChamp::selectByForm(myGet('idFormulaire'));     //appel au modèle pour gerer la BD
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
        $idChamp = myGet('idChamp');
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $tab_q = ModelChamp::select($idChamp);
            $tab_variable = ModelVariable::selectByForm(myGet("idFormulaire"));
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
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            if(!is_null(myGet('idChamp')) && !is_null(myGet('nomChamp')) && !is_null(myGet('idFormulaire')) && !is_null(myGet('typeChamp'))){

                $data = array('idChamp' => myGet('idChamp'),
                          'nomChamp' => myGet('nomChamp'),
                          'typeChamp' => myGet('typeChamp'),
                          'idFormulaire' => myGet('idFormulaire')
                      );

                if(!is_null(myGet('contexte'))){
                    $data['contexte'] = myGet('contexte');
                }

                if(!is_null(myGet('contexteImage'))){
                    $data['contexteImage'] = myGet('contexteImage');
                }

                if(!is_null(myGet('instructionReponse'))){
                    $data['instructionReponse'] = myGet('instructionReponse');
                }

                if(!is_null(myGet('max'))){
                    $data['valeurMaxChamp'] = myGet('max');
                }

                if (!is_null(myGet('idVariable'))) {
                    $data['idVariable'] = myGet('idVariable');
                }
                if (!is_null(myGet('coefficient'))) {
                    $data['coefficient'] = myGet('coefficient');
                }
                ModelChamp::update($data);
            }
            $idFormulaire = myGet('idFormulaire');
            $tab_q = ModelChamp::selectByForm(myGet('idFormulaire'));
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