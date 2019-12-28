<?php

	require_once (File::build_path(array("model","ModelVisualisation.php")));

	class ControllerVisualisation{
		protected static $object = 'visualisation';

		public static function error($errorType = NULL){
			$view='error'; $pagetitle='Erreur Visualisation';
			require (File::build_path(array("view","view.php")));
			die();
		}

		public static function readAll(){
			if(is_null(myGet('idFormulaire'))){
				self::error("Aucun idFormulaire fourni.");
			}

			if(!Session::is_admin()){
				self::error("Vous n'avez pas les droits.");
			}

			//On récupere les différentes variables existantes
			$tab_InfosVariables = ModelVisualisation::selectVariablesInfos(myGet('idFormulaire'));
			//var_dump($tab_InfosVariables);


			//On récupere les différentes réponses existantes
			$tab_InfosReponses = ModelVisualisation::selectReponsesInfos(myGet('idFormulaire'));

			if ($tab_InfosReponses != null) {
				foreach ($tab_InfosReponses as $reponse) {
					$tab_DataReponses[$reponse['idReponse']] = ModelVisualisation::select(myGet('idFormulaire'),$reponse['idReponse']);
				}
			}
			
			$view='VisualisationMultiple'; $pagetitle='Visualisation';
			require (File::build_path(array("view","view.php")));
		}



		public static function read(){
			if(is_null(myGet('idFormulaire')) || is_null(myGet('idReponse'))){
				self::error("Probleme de paramètres.");
			}

			if(!Session::is_admin()){
				self::error("Vous n'avez pas les droits.");
			}

			$tab_InfosVariables = ModelVisualisation::selectVariablesInfos(myGet('idFormulaire'));
			$tab_DataReponses = ModelVisualisation::select(myGet('idFormulaire'),myGet('idReponse'));


			$view='VisualisationSimple'; $pagetitle='Detail Visualisation';
			require (File::build_path(array("view","view.php")));
		}
		

	}



?>
