<?php
require_once File::build_path(array("model", "ModelFormulaire.php")); // chargement du modèle
class ControllerFormulaire {
    protected static $object = "formulaire";

    public static function readAll() {
        $tab_q = ModelFormulaire::selectAll();     //appel au modèle pour gerer la BD
        $controller='formulaire';
        $view='list';
        $pagetitle='Liste des formulaires';
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function read() {
    	$q = ModelFormulaire::select($_GET['idFormulaire']);
        $controller='formulaire';
        $view='detail';
        $pagetitle='Detail du formulaire';
        require File::build_path(array("view", "view.php"));
    }

    public static function create() {
        $controller='formulaire';
        $view='update';
        $pagetitle='Création de formulaire';
    	require File::build_path(array("view", "view.php"));
    }

    public static function created() {
    	$data = array('idFormulaire' => $_GET['idFormulaire'],
                        'nomFormulaire' => $_GET['nomFormulaire'],
                        'descriptionFormulaire' => $_GET['descriptionFormulaire'],
                        'idCreateur' => $_GET['idCreateur']);
        $controller='formulaire';
        $view='errorCreated';
        $pagetitle='Erreur lors de la création';
    	if(ModelFormulaire::save($data) == false) {
            require File::build_path(array("view", "view.php"));
    	}
    	else {
            $tab_q = ModelFormulaire::selectAll();
            $view='created';
            $pagetitle = 'Création réussie';
            require File::build_path(array("view", "view.php"));
    	}
    }

    public static function delete() {
        ModelFormulaire::delete($_GET['idFormulaire']);
        $idFormulaire = $_GET['idFormulaire'];
        $tab_q = ModelFormulaire::selectAll();
        $controller='formulaire';
        $view='deleted';
        $pagetitle='Car deleted';
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
        $controller='formulaire';
        $view='update';
        $pagetitle='Modification du f.ormulaire';
        require File::build_path(array("view", "view.php"));
    }

    public static function updated() {
        $data = array('idFormulaire' => $_GET['idFormulaire'],
                        'nomFormulaire' => $_GET['nomFormulaire'],
                        'descriptionFormulaire' => $_GET['descriptionFormulaire'],
                        'idCreateur' => $_GET['idCreateur']);
        ModelFormulaire::update($data);
        $tab_q = ModelFormulaire::selectAll();
        $controller='formulaire';
        $view='updated';
        $pagetitle='modification';
        require File::build_path(array("view", "view.php"));
    }
}
?>