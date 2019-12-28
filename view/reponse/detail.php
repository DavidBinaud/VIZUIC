<?php

    $idReponse = htmlspecialchars($tab_r->get('idReponse'));
    $nomReponse = htmlspecialchars($tab_r->get('nomReponse'));
    $idFormulaire = htmlspecialchars($tab_r->get('idFormulaire'));
	echo "<a class='btn-flat waves-effect' href='index.php?action=readAll&controller=reponse&idFormulaire=" . rawurldecode(myGet('idFormulaire')) . "'><i class='material-icons blue-text blue-accent-3'>arrow_back</i></a>";
    echo '
    <div class="container">
    <form method="';
    echo Conf::getDebug()?"GET":"POST" ;
    echo '" action="./index.php">
    		<input type="hidden" name="action" value="readAll"/>
    		<input type="hidden" name="controller" value="reponse"/>
    		<input type="hidden" name="idFormulaire" value="' . htmlspecialchars($idFormulaire) . '"/>
    		<input type="hidden" name="idReponse" value="' . htmlspecialchars($idReponse) . '"/>
    		<ul class ="collection">
    		<li class="collection-item">
    		<span class="formExtLegend"> Formulaire de VIZUIC </span>
    		</li>';

    		echo "
    		<li class='collection-item'>
    		<input type='text' name='nomReponse' id='type_id' placeholder='Inserer un titre' value='". htmlspecialchars($nomReponse) ."' disabled='disabled'/>
    		</li>";
    		
    		$cpt = 1;

    		if ($tab_q != NULL) {
    		
    		
    			foreach ($tab_q as $q){
    				
    				$nomChamp = htmlspecialchars($q->get("nomChamp"));
    				echo "
    				<li class='collection-item'>
    					<span class='formIntLegend' >" . $cpt++ . "</span>";
	
    				if($q->get("contexte") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			    	  					" . htmlspecialchars($q->get("contexte")) . "
			    	  				</strong>
			    				</p>";
			    	}

	    			echo "
			    		<p class='formSpaceChamp'>
			    			<strong>
			    	  			" . htmlspecialchars($nomChamp) . "
			    	  		</strong>
			   			</p>";


			    	if($q->get("contexteImage") != NULL){
			    		echo "<p class='formSpaceChamp'>
			    				<strong>
			      					" . htmlspecialchars($q->get("contexteImage")) . "
			      				</strong>
			    			</p>";
			    	}
			    	
			    	if($q->get("instructionReponse") != NULL){
			    		echo "<p class='formSpaceChamp'>
			    				<strong>
			      					" . htmlspecialchars($q->get("instructionReponse")) . "
			      				</strong>
			    			</p>";
			    	}

				    if($q->get("typeChamp") == "nombre"){


				    	$type = "text";

				    	if ($q->get('valeurChamp') != null) {
				    		$valeurChamp = $q->get('valeurChamp');
				    	} else {
				    		$valeurChamp = 0;
				    	}

				    	echo "<p>
			      				<input placeholder = 'Max : " . htmlspecialchars($q->get('valeurMaxChamp')) . "' type='" . $type . "' name='" . htmlspecialchars($q->get('idChamp')) . "' id='" . htmlspecialchars($q->get('idChamp')) . "' min='0' max='" . htmlspecialchars($q->get('valeurMaxChamp')) . "' step='0.01' value='" . htmlspecialchars($valeurChamp) . "' disabled/>
			    			</p>";
			    	} else if($q->get("typeChamp") == "echelle"){
				    	$type = "radio";

				    	if ($q->get('valeurChamp') != null) {
				    		$valeurChamp = $q->get('valeurChamp');
				    	} else {
				    		$valeurChamp = 1;
				    	}
					    
				    	$x = $q->get("valeurMaxChamp");

				    	if ($x > 10) {
				    			echo"<input type='text' class='js-range-slider' name='" . htmlspecialchars($q->get('idChamp')) . "' data-min='1' data-max='" . htmlspecialchars($x) . "' data-from='" . htmlspecialchars($valeurChamp) . "' value='" . htmlspecialchars($valeurChamp) . "' />";
				    	} else {

				    		echo "<div class='box'>";

						for ($i=1; $i <= $x; $i++) { 

							if (strcmp ( $i , $valeurChamp ) == 0 ) {
								echo "
									<p>
									<label>
        								<input type='$type' name='" . htmlspecialchars($q->get('idChamp')) . "'  value='$i' required checked/>
        								<span>$i</span>
      								</label>
      								</p>";
							} else {
								echo "
								<p>
									<label>
        								<input type='$type' name='" . htmlspecialchars($q->get('idChamp')) . "'  value='$i' required disabled='disabled'/>
        								<span>$i</span>
      								</label>
      								</p>";
								
							}
						}
						echo "</div>";
							
					}						

				    } else {
				    	$type = "text";

				    	if ($q->get('valeurChamp') != null) {
				    		$valeurChamp = $q->get('valeurChamp');
				    	} else {
				    		$valeurChamp = "";
				    	}

				    	echo "
				    		<p>
			      				<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='" . htmlspecialchars($q->get('idChamp')) . "' id='type_id' value='" . htmlspecialchars($valeurChamp) . "' disabled='disabled'/>
			    			</p>";
				    }
					
			 	echo "</li>";	
			}
		} else {
			echo "Il n'y a pas de questions";
		}
	
	echo "<li class='collection-item'>
			<button class='waves-effect waves-light btn blue accent-3 right' type='submit' value='Enregistrer'> Retour <i class='material-icons right'>exit_to_app</i> </button>
		</li>
	</ul>
	</form>
	</div>";

	echo"<div class='fixed-action-btn'><a href='index.php?action=update&controller=reponse&idReponse=" . rawurldecode($idReponse) . "&idFormulaire=" . rawurlencode($idFormulaire) . "' class='btn-floating btn-large waves-effect waves-light pulse white'><i class='large material-icons blue-text text-accent-3'>edit</i></a></div>"
?>

<script>
	$(".js-range-slider").ionRangeSlider({
		skin: "round"
	});
</script>



