<?php

require(File::build_path(array("model", "ModelUtilisateur.php")));
require_once(File::build_path(array("lib", "Security.php")));
require_once(File::build_path(array("lib", "Session.php")));

class ControllerUtilisateur {

	protected static $object = "utilisateur";

	
    public static function readAll() {
        if (Session::is_admin()) {
            $tab_u = ModelUtilisateur::selectAll();
            $controller='utilisateur';
            $view = "list";
            $pagetitle = "Liste des utilisateurs";
        } else {
            $u = ModelUtilisateur::select($_SESSION['Identifiant']);
            $controller='utilisateur';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        
        require (File::build_path(array("view", "view.php")));
    }

    public static function read() {

        if(!is_null(myGet("utilisateur"))) {

            $u = ModelUtilisateur::select(myGet("utilisateur"));
            if($u == false) {
            	$pagetitle = "Erreur lors de la lecture";
            	$view = "error";
                $errorType = "Cet utilisateur n'existe pas";
                $tab_j = ModelFormulaire::selectAll();
    			require(File::build_path(array("view", "view.php")));
    		}
    		else {
            	$pagetitle = "Détail de l'utilisateur";
            	$view = "profil";
    			require(File::build_path(array("view", "view.php")));
    		}
        }
    }

    public static function create() {
        if (Session::is_admin()) {
            $Identifiant = "";
            $nomUtilisateur = "";
            $email = "";
            $action = "created";
            $etat = "require";
            $legend = "Création d'un utilisateur";

            $view = "update";
            $pagetitle = "Création d'un utilisateur";
        } else {
            $u = ModelUtilisateur::select($_SESSION['Identifiant']);
            $controller='utilisateur';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }

        
        require(File::build_path(array("view", "view.php")));
    }

    public static function created() {
        if (Session::is_admin()) {

            if(!is_null(myGet("Identifiant"), myGet("nomUtilisateur"), myGet("mdp1"), myGet("mdp2"), myGet("email"))) {
                $data = array('Identifiant' => myGet("Identifiant"),
                                'nomUtilisateur' => myGet("nomUtilisateur"),
                                'est_Admin' => myGet('est_Admin'));

                if(myGet("mdp1") == myGet("mdp2")) {

                    if(filter_var(myGet("email"), FILTER_VALIDATE_EMAIL)) {
                        $mdp = Security::chiffrer(myGet("mdp1"));
                        $data['motDePasse'] = myGet("mdp1");
                        $data['email'] = myGet('email');

                        if(ModelUtilisateur::save($data)==true) {
                            $view = "created";
                            $tab_u = ModelUtilisateur::selectAll();
                        } else {
                            $errorType = "Ce Identifiant existe déjà, veuillez en choisir un autre";
                        }
                    } else {
                        $errorType = "L'email est invalide";
                    }
 
                } else {
                    $errorType = "Vos mots de passe ne correspondent pas";    
                }
            } else {
                $errorType = "Il manque des données"; 
            }

            if (isset($errorType)) {
                $view = "errorCreation";
                $action = "created";
                $etat = "require";
                $legend = "Création d'un utilisateur";
            }

            $pagetitle = "Création d'un utilisateur";
        } else {
            $u = ModelUtilisateur::select($_SESSION['Identifiant']);
            $controller='utilisateur';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require(File::build_path(array("view", "view.php")));
    }

    public static function error() {
        $u = ModelUtilisateur::select($_SESSION['Identifiant']);
        $controller='utilisateur';
        $view = "error";
        $errorType='Aucune action de ce type';
        $pagetitle = "Erreur action";
        require(File::build_path(array("view", "view.php")));
    }

    public static function delete() {

        if (Session::is_admin()) {
        
            ModelUtilisateur::delete(myGet("Identifiant"));
            $tab_u = ModelUtilisateur::selectAll();
            $controller='utilisateur';
            $view = "deleted";
            $pagetitle = "suppression d'un utilisateur";

                    
        } else {
            $u = ModelUtilisateur::select($_SESSION['Identifiant']);
            $controller='utilisateur';
            $view='error';
            $errorType='Vous n\'avez pas les droits';
            $pagetitle='Erreur droits';
        }
        require(File::build_path(array("view", "view.php")));
    }

    public static function update() {

        $pagetitle = "Modification d'un utilisateur";

        if(!is_null(myGet("Identifiant"))) {

            if(Session::is_user(myGet("Identifiant")) || Session::is_admin()) {  //accès réservé

                $user = ModelUtilisateur::select(myGet("Identifiant"));

                if($user == true) {
                    $Identifiant = myGet("Identifiant");
                    $etat = "readonly";
                    $view = "update";

                    $Identifiant = $user->get("Identifiant");
                    $nomUtilisateur = $user->get("nomUtilisateur");
                    $email = $user->get("email");
                    $est_Admin = $user->get("est_Admin");

                    $action = "updated";
                    $legend = "Modification d'un utilisateur";
                }
                else {
                    $errorType = "Cet utilisateur n'existe pas";
                    $view = "error";
                    
                }
            }
            else {
                $view="connect";
            }
        }
        else {
            $pagetitle = "erreur lors de la Modification";
            $view = "error";
            $errorType = "Il faut spécifier un Identifiant";
        }
        require(File::build_path(array("view", "view.php")));
    }

    public static function updated() {

        if(!is_null(myGet("Identifiant"), myGet("nomUtilisateur"), myGet("mdp1"), myGet("mdp2"), myGet("email")) && myGet("mdp1") == myGet("mdp2")) {

            if(Session::is_user(myGet("Identifiant")) || Session::is_admin()) { //accès réservé

                if(filter_var(myGet("email"), FILTER_VALIDATE_EMAIL)) {

                    $est_Admin = 0;
                    if(!is_null(myGet("est_Admin")) && myGet("est_Admin") == "on") {
                        $est_Admin = 1;
                    }


                    $mdp = Security::chiffrer(myGet("mdp1"));
                    ModelUtilisateur::update(array("Identifiant" => myGet("Identifiant"), "nomUtilisateur" => myGet("nomUtilisateur"), "motDePasse" => $mdp, "est_Admin" => $est_Admin, "email" => myGet("email")));

                    $view = "updated";
                    $pagetitle = "Modification de l'utilisateur";
                    if (Session::is_admin() && (strcmp($_SESSION['Identifiant'],myGet('Identifiant')) !=0) ) {
                        $tab_u = ModelUtilisateur::selectAll();
                    } else {
                        $u = ModelUtilisateur::select($_SESSION["Identifiant"]);
                    }
                    
                }
                else {
                    $view = "errorCreation";
                    $pagetitle = "Modification utilisateur";
                    $action = "updated";
                    $errorType = "L'email n'est pas valide";
                    $etat = "readonly";
                    $legend = "Modification d'un utilisateur";
                }
            }
            else {
                $view="connect";
            }

        }
        else {
            $view = "errorCreation";
            $pagetitle = "Modification utilisateur";
            $action = "updated";
            $errorType = "Vos mots de passe ne correspondent pas ou il manque des informations";
            $etat = "readonly";
            $legend = "Modification d'un utilisateur";
        }
        require(File::build_path(array("view", "view.php")));
    }

    public static function connect() {

        if(isset($_SESSION["Identifiant"])) {
            $view = "profil";
            $pagetitle = "Mon profil";
            $u = ModelUtilisateur::select($_SESSION["Identifiant"]);
        }
        else {
            $Identifiant = "";
            $view="connect";
            $pagetitle="Page de connexion";
        }

        require(File::build_path(array("view", "view.php")));
    }

    public static function connected() {
        if(!is_null(myGet("Identifiant"), myGet("password"))) {

            $u = ModelUtilisateur::select(myGet("Identifiant"));

            if(ModelUtilisateur::checkPassword(myGet("Identifiant"), myGet("password")) == true) {
                    
                    $view = "profil";
                    $pagetitle = "Mon profil";

                    $_SESSION["est_Admin"]=$u->get("est_Admin");
                       
            } else {
                $Identifiant = myGet("Identifiant");
                $view = "errorConnect";
                $errorType="Mauvais mot de passe ou Identifiant";
                $pagetitle="Page de connexion";
            }
        } else {
            $view="connect";
            $pagetitle="Page de connexion";
        }
        require(File::build_path(array("view", "view.php")));
    }

    public static function deconnect() {

        session_unset();
        session_destroy();

        $tab_q = ModelFormulaire::selectAll();
        $view = "deconnected";
        $pagetitle = "Déconnection";
        require(File::build_path(array("view", "view.php")));
    }

}

?>