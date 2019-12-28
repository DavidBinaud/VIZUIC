<?php

	require_once (File::build_path(array("model","ModelVisualisation.php")));

	class ControllerVisualisation{
		protected static $object = 'visualisation';

		public static function error(){
			$view='error'; $pagetitle='Erreur Visualisation'; $errorType = "Erreur Générale";
			require (File::build_path(array("view","view.php")));
			die();
		}

		public static function readAll(){
			if(!isset($_GET['idFormulaire'])){
				self::error();
			}

			//On récupere les différentes variables existantes
			$tab_InfosVariables = ModelVisualisation::selectVariablesInfos($_GET['idFormulaire']);
			//var_dump($tab_InfosVariables);


			//On récupere les différentes réponses existantes
			$tab_InfosReponses = ModelVisualisation::selectReponsesInfos($_GET['idFormulaire']);


			foreach ($tab_InfosReponses as $reponse) {
				$tab_DataReponses[$reponse['idReponse']] = ModelVisualisation::select($_GET['idFormulaire'],$reponse['idReponse']);
			}


			$view='VisualisationMultiple'; $pagetitle='Visualisation';
			require (File::build_path(array("view","view.php")));
		}



		public static function read(){
			if(!isset($_GET['idFormulaire']) && !isset($_GET['idReponse'])){
				self::error();
			}

			$tab_InfosVariables = ModelVisualisation::selectVariablesInfos($_GET['idFormulaire']);
			$tab_DataReponses = ModelVisualisation::select($_GET['idFormulaire'],$_GET['idReponse']);


			$view='VisualisationSimple'; $pagetitle='Detail Visualisation';
			require (File::build_path(array("view","view.php")));
		}
		

	}



?>
