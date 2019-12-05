<?php

	require_once (File::build_path(array("model","ModelVisualisation.php")));

	class ControllerVisualisation{
		protected static $object = 'visualisation';

		public static function error(){
			$view='error'; $pagetitle='Erreur Visualisation'; $errorType = "Erreur Générale";
			require (File::build_path(array("view","view.php")));
		}

		public static function readAll(){
			

			//On récupere les différentes variables existantes
			$tab_InfosVariables = ModelVisualisation::selectVariablesInfos($_GET['idFormulaire']);
			//var_dump($tab_InfosVariables);


			//On récupere les différentes réponses existantes
			$tab_InfosReponses = ModelVisualisation::selectReponsesInfos($_GET['idFormulaire']);
			//var_dump($tab_InfosReponses);

			foreach ($tab_InfosReponses as $reponse) {
				$tab_DataReponses[$reponse['idReponse']] = ModelVisualisation::select($_GET['idFormulaire'],$reponse['idReponse']);
			}
			//var_dump($tab_DataReponses);
			
			//var_dump($tab_variables[0]);

			$view='testVisualisationMultiple'; $pagetitle='Visualisation';
			require (File::build_path(array("view","view.php")));
		}



		public static function read(){
			if(isset($_GET['idFormulaire'])){
				/*$c = ModelChamp::select($_GET['id']);
				if($c == false){
					
					$view='error'; $pagetitle='Erreur Visualisation'; $errorType = "Read d'une Visualisation: id fourni non existant";
					require (File::build_path(array("view","view.php")));
				}else
				{*/



					$tab_InfosVariables = ModelVisualisation::selectVariablesInfos($_GET['idFormulaire']);
					$tab_DataReponses = ModelVisualisation::select($_GET['idFormulaire'],$_GET['idReponse']);




					$view='TestVisualisationCheckboxes'; $pagetitle='Detail Visualisation';
					require (File::build_path(array("view","view.php")));
				/*}
			}else{
				$view='error'; $pagetitle='Erreur Visualisation'; $errorType = "Read d'une Visualisation: Pas d'id fourni";
				require (File::build_path(array("view","view.php")));
				*/
			}
		}
		

	}



?>