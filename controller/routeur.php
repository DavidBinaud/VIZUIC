<?php
require_once File::build_path(array("controller", "ControllerFormulaire.php"));
require_once File::build_path(array("controller", "ControllerChamp.php"));
require_once File::build_path(array("controller", "ControllerUtilisateur.php"));
require_once File::build_path(array("controller", "ControllerVisualisation.php"));

// On recupère l'action passée dans l'URL

$controller_default = "utilisateur";

if (isset($_SESSION["Identifiant"]) && isset($_GET['controller']) == true && isset($_GET['action']) == true) {
	$controller = $_GET['controller'];
	$controller_class = 'Controller' . ucfirst($controller);
	
	if (!class_exists($controller_class)) {
		$controller_class = 'ControllerFormulaire';
		$action = 'error';
	} else {
		$methodsController = get_class_methods($controller_class);
		if (in_array($_GET['action'], $methodsController)) {
			$action = $_GET['action'];
		} else {
			$action = 'error';
		}
	}
} else if ($controller == 'utilisateur' && isset($_GET['action']) && $_GET['action'] == 'connected') {
	$controller_class = 'Controller' . ucfirst($controller);
	$action = $_GET['action'];

} else {
	$controller_class = 'Controller' . ucfirst($controller_default);
	$action = 'connect';
}
	

// Appel de la méthode statique $action de ControllerVoiture
$controller_class::$action();
?>