<?php
require_once File::build_path(array("model", "ModelReponse.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelReponseChamp.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelReponseVariable.php")); // chargement du modèle
//require_once File::build_path(array("model", "ModelChamp.php")); // chargement du modèle
require_once File::build_path(array("lib", "Session.php" ));

class ControllerReponse {
    protected static $object = "reponse";

    public static function readAll() {
        if(Session::is_admin()){
            $tab_r = ModelReponse::selectAll();     //appel au modèle pour gerer la BD
        } else {
            $tab_r = ModelReponse::selectAllByForm($_GET['idFormulaire']);     //appel au modèle pour gerer la BD
        }
        
        $controller='reponse';
        $view='list';
        $pagetitle='Liste des réponses';
        if (isset($_GET['gestion'])) {
            $gestion = $_GET['gestion'];
        } else {
            $gestion = 0;
        }
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function read() {
    	$r = ModelReponse::select($_GET['idReponse']);
        $controller='reponse';
        $view='detail';
        $pagetitle='Detail de la reponse';
        if (isset($_GET['gestion'])) {
            $gestion = $_GET['gestion'];
        } else {
            $gestion = 0;
        }
        
        require File::build_path(array("view", "view.php"));
    }

//    public static function create() {
//        $controller='formulaire';
//        $view='update';
//        $pagetitle='Création de formulaire';
//    	require File::build_path(array("view", "view.php"));
//    }

    public static function created() {

        $tab_Champ = ModelChamp::selectByForm($_GET['idFormulaire']);

        $data = array('nomReponse' => $_GET['nomReponse'],
                        'idFormulaire' => $_GET['idFormulaire']);


        
        if(ModelReponse::save($data) == false) {
            $controller='formulaire';
            $view='errorCreated';
            $pagetitle='Erreur lors de la création de la réponse';
        } else {
            //fonction qui renvoi l'id de la derniere reponse inseree
            $idReponse = ModelReponse::getLastCreated();
           
            foreach ($tab_Champ as $champ) {
                $idChamp = $champ->get('idChamp');
                $data2 =  array('idReponse' => $idReponse,
                                'idChamp' => $idChamp, 
                                'valeurChamp' => $_GET["$idChamp"]);

                ModelReponseChamp::save($data2);

            }

            $tab_r = ModelReponse::selectAllByForm($_GET['idFormulaire']);
            $controller = 'reponse';
            $view='updated';
            $pagetitle = 'Réponse enregistrée';
            $gestion = 0;
        }
        require File::build_path(array("view", "view.php"));
    }

    public static function delete() {
        ModelReponse::delete($_GET['idReponse']);
        $idFormulaire = $_GET['idFormulaire'];
        $tab_r = ModelReponse::selectAllByForm($idFormulaire);
        $controller='reponse';
        $view='deleted';
        $pagetitle='Réponse supprimée';
        $gestion = 1;
        require File::build_path(array("view", "view.php"));
    }

    public static function error() {
        $controller='reponse';
        $view='errorAction';
        $pagetitle='Aucune action de ce type';
        require File::build_path(array("view", "view.php"));
    }

    public static function update() {
        $idFormulaire = $_GET['idFormulaire'];
        $idReponse = $_GET['idReponse'];
        $tab_r = ModelReponse::select($idReponse);
        $tab_q = ModelReponseChamp::selectByReponse($idReponse);
        //$tab_q = ModelChamp::selectByForm($idFormulaire);
        $controller='reponse';
        $view='update';
        $pagetitle='Modification de la reponse';
        $gestion=0;
        require File::build_path(array("view", "view.php"));
    }

    public static function updated() {
        $tab_Champ = ModelChamp::selectByForm($_GET['idFormulaire']);

        $data = array('idReponse' => $_GET['idReponse'],
                        'nomReponse' => $_GET['nomReponse'],
                        'idFormulaire' => $_GET['idFormulaire']);
        
        ModelReponse::update($data);
        $idReponse = $_GET['idReponse'];

        foreach ($tab_Champ as $champ) {
            $idChamp = $champ->get('idChamp');
            $data2 =  array('idReponse' => $idReponse,
                            'idChamp' => $idChamp, 
                            'valeurChamp' => $_GET["$idChamp"]);

            ModelReponseChamp::update($data2);

        }
        
        
        $tab_r = ModelReponse::selectAllByForm($_GET['idFormulaire']);
        $controller='reponse';
        $view='updated';
        $pagetitle = 'Réponse modifiée';
        $gestion = 0;
        require File::build_path(array("view", "view.php"));
    }

}
?>