<?php

require(File::build_path(array("model", "ModelUtilisateur.php")));
require_once(File::build_path(array("lib", "Security.php")));
require_once(File::build_path(array("lib", "Session.php")));

class ControllerUtilisateur {

	protected static $object = "utilisateur";

	
    public static function readAll() {
        $tab_u = ModelUtilisateur::selectAll();
        $view = "list";
        $pagetitle = "Liste des utilisateurs";
        require (File::build_path(array("view", "view.php")));
    }

    public static function read() {

        if(isset($_GET["utilisateur"])) {

            $u = ModelUtilisateur::select($_GET["utilisateur"]);
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

        $Identifiant = "";
        $nomUtilisateur = "";
        $email = "";
        $action = "created";
        $etat = "require";
        $legend = "Création d'un utilisateur";

        $view = "update";
        $pagetitle = "Création d'un utilisateur";
        require(File::build_path(array("view", "view.php")));
    }

    public static function created() {

        if(isset($_GET["Identifiant"], $_GET["nomUtilisateur"], $_GET["mdp1"], $_GET["mdp2"], $_GET["email"])) {

            if($_GET["mdp1"] == $_GET["mdp2"]) {

                if(filter_var($_GET["email"], FILTER_VALIDATE_EMAIL)) {
                    $mdp = Security::chiffrer($_GET["mdp1"]);
                    $nonce = Security::generateRandomHex();

                    $data=array("Identifiant" => $_GET["Identifiant"], "nomUtilisateur" => $_GET["nomUtilisateur"], "mdp" => $mdp, "mail" => $_GET["email"], "nonce" => $nonce);

                    $mail = "Bienvenue sur le site, veuillez valider votre addresse mail <a href=\"http://webinfo.iutmontp.univ-montp2.fr/~capelln/VIZUIC/index.php?action=validate&controller=utilisateur&Identifiant=" . $_GET["Identifiant"] . "&nonce=" . $nonce . "\">ici</a>";

                    mail("bob@yopmail.com", "Validation de votre adresse mail", $mail);

                    if(ModelUtilisateur::save($data)==true) {
                        $view = "created";
                        $u = ModelUtilisateur::select($_GET["Identifiant"]);
                    }
                    else {
                        $errorType = "Ce Identifiant existe déjà, veuillez en choisir un autre";
                    }
                }
                else {
                    $errorType = "L'email est invalite";
                }
 
            }
            else {
                $errorType = "Vos mots de passe ne correspondent pas";    
            }
        }
        else {
            $errorType = "Il manque des données";
            
        }

        if (isset($errorType)) {
            $view = "errorCreation";
            $action = "created";
            $etat = "require";
            $legend = "Création d'un utilisateur";
        }

        $pagetitle = "Création d'un utilisateur";
        require(File::build_path(array("view", "view.php")));
    }

    public static function error() {

        $view = "error";
        $pagetitle = "Erreur";
        $tab_j = ModelJeu::selectAll();
        require(File::build_path(array("view", "view.php")));
    }

    public static function delete() {

        $pagetitle = "suppression d'un utilisateur";

        if(isset($_GET["Identifiant"]) && ModelUtilisateur::select($_GET["Identifiant"])) {

            $Identifiant = $_GET["Identifiant"];

            if(Session::is_user($_GET["Identifiant"])) {
                ModelUtilisateur::delete($Identifiant);
                $tab_u = ModelUtilisateur::selectAll();
                $view = "deleted";

                session_unset();
                session_destroy();
            } else if (Session::is_admin()) {
                ModelUtilisateur::delete($Identifiant);
                $tab_u = ModelUtilisateur::selectAll();
                $view = "deleted";
            } else {

                $view="connect";
            }
        }
        else {
            $errorType = "";
            $view = "error";
            $tab_j = ModelJeu::selectAll();
        }
        require(File::build_path(array("view", "view.php")));
    }

    public static function update() {

        $pagetitle = "Modification d'un utilisateur";

        if(isset($_GET["Identifiant"])) {

            if(Session::is_user($_GET["Identifiant"]) || Session::is_admin()) {  //accès réservé

                $user = ModelUtilisateur::select($_GET["Identifiant"]);

                if($user == true) {
                    $Identifiant = $_GET["Identifiant"];
                    $etat = "readonly";
                    $view = "update";

                    $Identifiant = $user->get("Identifiant");
                    $nomUtilisateur = $user->get("nomUtilisateur");
                    $email = $user->get("mail");
                    $admin = $user->get("admin");

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

        if(isset($_GET["Identifiant"], $_GET["nomUtilisateur"], $_GET["mdp1"], $_GET["mdp2"], $_GET["email"]) && $_GET["mdp1"] == $_GET["mdp2"]) {

            if(Session::is_user($_GET["Identifiant"]) || Session::is_admin()) { //accès réservé

                if(filter_var($_GET["email"], FILTER_VALIDATE_EMAIL)) {

                    $admin = 0;
                    if(isset($_GET["admin"]) && $_GET["admin"] == "on") {
                        $admin = 1;
                    }


                    $mdp = Security::chiffrer($_GET["mdp1"]);
                    ModelUtilisateur::update(array("Identifiant" => $_GET["Identifiant"], "nomUtilisateur" => $_GET["nomUtilisateur"], "mdp" => $mdp, "admin" => $admin, "mail" => $_GET["email"]));

                    $view = "updated";
                    $pagetitle = "Modification de l'utilisateur'";
                    $u = ModelUtilisateur::select($_GET["Identifiant"]);
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
        if(isset($_GET["Identifiant"], $_GET["password"])) {

            $u = ModelUtilisateur::select($_GET["Identifiant"]);

            if(ModelUtilisateur::checkPassword($_GET["Identifiant"], $_GET["password"]) == true) {
                    
                if(!is_null($u) && is_null($u->get("nonce"))) {

                    $view = "profil";
                    $pagetitle = "Mon profil";

                    $_SESSION["admin"]=$u->get("admin");
                }
                else {
                    $Identifiant = $_GET["Identifiant"];
                    $view = "errorConnect";
                    $errorType="Vous n'avez pas validé votre adresse mail";
                    $pagetitle="Page de connexion";
                }   
            } else {
                $Identifiant = $_GET["Identifiant"];
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

        $tab_j = ModelJeu::selectAll();
        $view = "deconnected";
        $pagetitle = "Déconnection";
        require(File::build_path(array("view", "view.php")));
    }

    public static function validate() {
        if(isset($_GET["Identifiant"], $_GET["nonce"])) {

            $user = ModelUtilisateur::select($_GET["Identifiant"]);

            if(!is_null($user) && $user->get("nonce") == $_GET["nonce"]) {
                ModelUtilisateur::update(array("Identifiant" => $_GET["Identifiant"], "nonce" => NULL));
                $view="validated";
                $pagetitle="Adresse mail validé";
            }
            else {
                $errorType="Nonce invalide";
                $view="error";
            }
        }
        else {
            $errorType="Les parametres sont invalides";
            $view="error";
        }

        require(File::build_path(array("view", "view.php")));

    }
}

?>