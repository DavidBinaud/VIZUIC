<?php

	require_once (File::build_path(array("model","ModelVisualisation.php")));

	class ControllerVisualisation{
		protected static $object = 'visualisation';

		public static function error(){
			$view='error'; $pagetitle='Erreur Visualisation'; $errorType = "Erreur Générale";
			require (File::build_path(array("view","view.php")));
		}

		public static function readAll(){
			

			$view='visualisationSimple'; $pagetitle='Visualisation';
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
					$tab_variables = ModelVisualisation::select($_GET['idFormulaire'],$_GET['idReponse']);

					$view='visualisationSimple'; $pagetitle='Detail Visualisation';
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