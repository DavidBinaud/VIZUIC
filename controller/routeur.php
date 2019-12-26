<?php
require_once File::build_path(array("controller", "ControllerFormulaire.php"));
require_once File::build_path(array("controller", "ControllerChamp.php"));
require_once File::build_path(array("controller", "ControllerUtilisateur.php"));
require_once File::build_path(array("controller", "ControllerVisualisation.php"));
require_once File::build_path(array("controller", "ControllerReponse.php"));


function myGet($nomVar){
	if (isset($_GET[$nomVar])) {
		return $_GET[$nomVar];
	} else if (isset($_POST[$nomVar])) {
		return $_POST[$nomVar];
	} else {
		return NULL;
	}
}
// On recupère l'action passée dans l'URL

$controller_default = "utilisateur";

if (isset($_SESSION["Identifiant"]) && !is_null(myGet('controller')) && !is_null(myGet('action'))) {	
	$controller = myGet('controller');
	$controller_class = 'Controller' . ucfirst($controller);
	
	if (!class_exists($controller_class)) {
		$controller_class = 'ControllerFormulaire';
		$action = 'error';
	} else {
		$methodsController = get_class_methods($controller_class);
		if (in_array(myGet('action'), $methodsController)) {
			$action = myGet('action');
		} else {
			$action = 'error';
		}
	}
} else if (!is_null(myGet('controller')) && myGet('controller') == 'utilisateur' && !is_null(myGet('action')) && myGet('action') == 'connected') {
	$controller = myGet('controller');
	$controller_class = 'Controller' . ucfirst($controller);
	$action = myGet('action');

} else {
	$controller_class = 'Controller' . ucfirst($controller_default);
	$action = 'connect';
}
	

// Appel de la méthode statique $action de ControllerVoiture
$controller_class::$action();
?>