<?php
require_once File::build_path(array("model", "ModelReponse.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelReponseChamp.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelReponseVariable.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelVariable.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelFormulaire.php")); // chargement du modèle
require_once File::build_path(array("lib", "Session.php" ));

class ControllerReponse {
    protected static $object = "reponse";

    public static function readAll() {
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $tab_r = ModelReponse::selectAllByForm(myGet('idFormulaire'));     //appel au modèle pour gerer la BD
            $controller='reponse';
            $view='list';
            $pagetitle='Liste des réponses';
            if (!is_null(myGet('gestion'))) {
                $gestion = myGet('gestion');
            } else {
                $gestion = 0;
            }
        } else {
            $tab_q=ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='reponse';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function read() {
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
    	   $idFormulaire = myGet('idFormulaire');
            $idReponse = myGet('idReponse');
            $data =  array('idReponse' => $idReponse,
                        'idFormulaire' => $idFormulaire );
            $tab_r = ModelReponse::select($idReponse);
            $tab_q = ModelReponseChamp::selectByReponse($data);
            $controller='reponse';
            $view='detail';
            $pagetitle='Detail de la reponse';
            $gestion=0;
        } else {
            $tab_q=ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='reponse';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
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
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {

            $tab_Champ = ModelChamp::selectByForm(myGet('idFormulaire'));
            $tab_variable = ModelVariable::selectByForm(myGet('idFormulaire'));

            foreach ($tab_variable as $v) {
                ${$v['idVariable']} = 0;
                $den{$v['idVariable']} = 0;
            }

            $data = array('nomReponse' => myGet('nomReponse'),
                        'idFormulaire' => myGet('idFormulaire'));


        
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
                                'valeurChamp' => myGet("$idChamp"));
                    ModelReponseChamp::save($data2);
                    if ($champ->get('idVariable') != null && $champ->get('coefficient') != null) {
                        ${$champ->get('idVariable')} +=  (myGet("$idChamp") * 10 * $champ->get('coefficient')) / $champ->get('valeurMaxChamp');
                        $den{$champ->get('idVariable')} +=  $champ->get('coefficient');
                    }

                }

                foreach ($tab_variable as $v) {
                    if ($den{$v['idVariable']} != 0) {
                        ${$v['idVariable']} = ${$v['idVariable']} / $den{$v['idVariable']};
                    }
               
                    $data3 = array('idReponse' => $idReponse,
                                'idVariable' => $v['idVariable'],
                                'valeurVariable' => ${$v['idVariable']});
                    ModelReponseVariable::save($data3);
                }

                $tab_r = ModelReponse::selectAllByForm(myGet('idFormulaire'));
                $controller = 'reponse';
                $view='updated';
                $pagetitle = 'Réponse enregistrée';
                $gestion = 0;
            }
        } else {
            $tab_q=ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='reponse';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require File::build_path(array("view", "view.php"));
    }

    public static function delete() {
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            ModelReponse::delete(myGet('idReponse'));
            $idFormulaire = myGet('idFormulaire');
            $tab_r = ModelReponse::selectAllByForm($idFormulaire);
            $controller='reponse';
            $view='deleted';
            $pagetitle='Réponse supprimée';
            $gestion = 1;
        } else {
            $tab_q=ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='reponse';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require File::build_path(array("view", "view.php"));
    }

    public static function error() {
        $controller='reponse';
        $view='error';
        $errorType='Aucune action de ce type';
        $pagetitle='Erreur action';
        require File::build_path(array("view", "view.php"));
    }

    public static function update() {
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $idFormulaire = myGet('idFormulaire');
            $idReponse = myGet('idReponse');
            $data = array('idReponse' => $idReponse,
                        'idFormulaire' => $idFormulaire );
            $tab_r = ModelReponse::select($idReponse);
            $tab_q = ModelReponseChamp::selectByReponse($data);
            $controller='reponse';
            $view='update';
            $pagetitle='Modification de la reponse';
            $gestion=0;
        } else {
            $tab_q=ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='reponse';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require File::build_path(array("view", "view.php"));
    }

    public static function updated() {
        $formulaire = ModelFormulaire::select(myGet('idFormulaire'));
        if (Session::is_admin() | strcmp($_SESSION['Identifiant'], $formulaire->get('idCreateur')) == 0) {
            $tab_Champ = ModelChamp::selectByForm(myGet('idFormulaire'));
            $tab_variable = ModelVariable::selectByForm(myGet('idFormulaire'));

            foreach ($tab_variable as $v) {
                ${$v['idVariable']} = 0;
                $den{$v['idVariable']} = 0;
            }

            $data = array('idReponse' => myGet('idReponse'),
                        'nomReponse' => myGet('nomReponse'),
                        'idFormulaire' => myGet('idFormulaire'));
        
            ModelReponse::update($data);
            $idReponse = myGet('idReponse');

            foreach ($tab_Champ as $champ) {
                $idChamp = $champ->get('idChamp');
                $data2 =  array('idReponse' => $idReponse,
                            'idChamp' => $idChamp, 
                            'valeurChamp' => myGet("$idChamp"));
                if (ModelReponseChamp::select($data2) != null) {
                    ModelReponseChamp::update($data2);
                } else {
                    ModelReponseChamp::save($data2);
                }

                if ($champ->get('idVariable') != null && $champ->get('coefficient') != null) {
                    ${$champ->get('idVariable')} +=  (myGet("$idChamp") * 10 * $champ->get('coefficient')) / $champ->get('valeurMaxChamp');
                    $den{$champ->get('idVariable')} +=  $champ->get('coefficient');
                }

            }

            foreach ($tab_variable as $v) {
                if ($den{$v['idVariable']} != 0) {
                    ${$v['idVariable']} = ${$v['idVariable']} / $den{$v['idVariable']};
                }
               
                $data3 = array('idReponse' => $idReponse,
                                'idVariable' => $v['idVariable'],
                                'valeurVariable' => ${$v['idVariable']});
                ModelReponseVariable::update($data3);
            }
        
        
            $tab_r = ModelReponse::selectAllByForm(myGet('idFormulaire'));
            $controller='reponse';
            $view='updated';
            $pagetitle = 'Réponse modifiée';
            $gestion = 0;
        } else {
            $tab_q=ModelFormulaire::selectAllByUser($_SESSION['Identifiant']);
            $controller='reponse';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require File::build_path(array("view", "view.php"));
    }

}
?>