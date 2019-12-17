<?php

    $idReponse = htmlspecialchars($tab_r->get('idReponse'));
    $nomReponse = htmlspecialchars($tab_r->get('nomReponse'));
    $idFormulaire = htmlspecialchars($tab_r->get('idFormulaire'));

	$idFormulaire = $_GET['idFormulaire'];
    echo '
    <form method="get" action="./index.php">
    	<fieldset class ="formExt">
    		<input type="hidden" name="action" value="updated"/>
    		<input type="hidden" name="controller" value="reponse"/>
    		<input type="hidden" name="idFormulaire" value="' . $idFormulaire . '"/>
    		<input type="hidden" name="idReponse" value="' . $idReponse . '"/>
    		<legend class="formExtLegend"> Formulaire de VIZUIC </legend>';

    		if($gestion == 1) {
    			echo"
    				<a class='waves-effect waves-light btn blue lighten-1' href='index.php?action=create&controller=champ&idFormulaire=" . rawurlencode($idFormulaire) . "'>Ajouter une question</a>";
    		} else {
    			echo "<input type='text' name='nomReponse' id='type_id' placeholder='Inserer un titre' value='". $nomReponse ."'requiered/>";
    		}
    		
    		$cpt = 1;

    		if ($tab_q != NULL) {
    		
    		
    			foreach ($tab_q as $q){
    				
    				$nomChamp = htmlspecialchars($q->get("nomChamp"));
    				echo "
    				<fieldset class='formInt'>";
	
    				if($q->get("contexte") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			    	  					{$q->get("contexte")}
			    	  				</strong>
			    				</p>";
			    	}

	    			echo "<legend class='formIntLegend' >" . $cpt++ . "</legend>
			    		<p class='formSpaceChamp'>
			    			<strong>
			    	  			{$nomChamp}
			    	  		</strong>
			   			</p>";


			    	if($q->get("contexteImage") != NULL){
			    		echo "<p class='formSpaceChamp'>
			    				<strong>
			      					{$q->get("contexteImage")}
			      				</strong>
			    			</p>";
			    	}
			    	
			    	if($q->get("instructionReponse") != NULL){
			    		echo "<p class='formSpaceChamp'>
			    				<strong>
			      					{$q->get("instructionReponse")}
			      				</strong>
			    			</p>";
			    	}

				    if($q->get("typeChamp") == "nombre"){


				    	$type = "text";

				    	echo "<p>
			      				<input placeholder = 'Exemple : 10' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' pattern='[0-9]' value='{$q->get('valeurChamp')}' required/>
			    			</p>";
			    	} else if($q->get("typeChamp") == "echelle"){
				    	$type = "radio";
	
				    	echo "<div class='box'>";

				    
				    	$x = $q->get("valeurMaxChamp");

						for ($i=1; $i <= $x; $i++) { 

							if (strcmp ( $i , $q->get('valeurChamp') ) == 0 ) {
								echo "
									<div class='radiobox'>
										<label for='type_id'>$i</label>
									</div>
									<label>
        								<input type='$type' name='{$q->get('idChamp')}'  value='$i' id='type_id' checked required/>
        								<span></span>
      								</label>";
							} else {
								echo "
								<div class='radiobox'>
									<label for='type_id'>$i</label>
								</div>
								<label>
        							<input type='$type' name='{$q->get('idChamp')}'  value='$i' id='type_id' required/>
        							<span></span>
      							</label>";
								
							}
							
						}

						echo "</div>";

				    } else {
				    	$type = "text";
				    	echo "
				    		<p>
			      				<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' value='{$q->get('valeurChamp')}' required/>
			    			</p>";
				    }
					

			    	if ($gestion == 1) {
				  		echo"
				  		<a class='waves-effect waves-light btn blue lighten-1'  href='./index.php?action=update&controller=champ&idChamp={$q->get('idChamp')}&idFormulaire={$q->get('idFormulaire')}'>Modifier</a>
			   			<a class='waves-effect waves-light btn blue lighten-1'  href='./index.php?action=delete&controller=champ&idChamp={$q->get('idChamp')}&idFormulaire={$q->get('idFormulaire')}'>Supprimer</a>";
				  	}
			 	echo "</fieldset>";	
			}
		} else {
			echo "Il n'y a pas de questions";
		}
	
	echo "
	</fieldset>
	";

	if ($gestion != 1){
		echo"<p>
		<input class='waves-effect waves-light btn blue lighten-1' type='submit' value='Envoyer' />
	</p>";
	}
	echo "
	</form>";
?>