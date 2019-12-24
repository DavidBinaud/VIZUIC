<?php

    $idReponse = htmlspecialchars($tab_r->get('idReponse'));
    $nomReponse = htmlspecialchars($tab_r->get('nomReponse'));
    $idFormulaire = htmlspecialchars($tab_r->get('idFormulaire'));

	$idFormulaire = $_GET['idFormulaire'];
    echo '
    <div class="container">
    <form method="get" action="./index.php">
    	<fieldset class ="formExt">
    		<input type="hidden" name="action" value="updated"/>
    		<input type="hidden" name="controller" value="reponse"/>
    		<input type="hidden" name="idFormulaire" value="' . $idFormulaire . '"/>
    		<input type="hidden" name="idReponse" value="' . $idReponse . '"/>
    		<ul class ="collection">
    		<li class="collection-item">
    		<span class="formExtLegend"> Formulaire de VIZUIC </span>
    		</li';

   			echo "
    		<li class='collection-item'>
    		<input type='text' name='nomReponse' id='type_id' placeholder='Inserer un titre' value='". $nomReponse ."' required/>
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
			    	  					{$q->get("contexte")}
			    	  				</strong>
			    				</p>";
			    	}

	    			echo "
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

				    	if ($q->get('valeurChamp') != null) {
				    		$valeurChamp = $q->get('valeurChamp');
				    	} else {
				    		$valeurChamp = 0;
				    	}

				    	$type = "text";

				    	echo "<p>
				    			<input placeholder = 'Max : {$q->get('valeurMaxChamp')}' type='" . $type . "' name='{$q->get('idChamp')}' id='{$q->get('idChamp')}' min='0' max='" . $q->get('valeurMaxChamp') . "' step='0.01' value='{$valeurChamp}' required/>
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
				    			echo"<input type='text' class='js-range-slider' name='{$q->get('idChamp')}' data-min='1' data-max='" . $x . "' data-from='{$valeurChamp}' value='' />";
				    	
				    	} else {

				    		echo "<div class='box'>";

						for ($i=1; $i <= $x; $i++) { 

							if (strcmp ( $i , $valeurChamp ) == 0 ) {
								echo "
									<p>
									<label>
        								<input type='$type' name='{$q->get('idChamp')}'  value='$i' required checked/>
        								<span>$i</span>
      								</label>
      								</p>";
							} else {
								echo "
								<p>
									<label>
        								<input type='$type' name='{$q->get('idChamp')}'  value='$i' required />
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
			      				<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' value='{$valeurChamp}' required/>
			    			</p>";
				    }
					
			 	echo "</li>";	
			}
		} else {
			echo "Il n'y a pas de questions";
		}
	
	echo"<li class='collection-item'>
			<button class='waves-effect waves-light btn blue accent-3 right' type='submit' value='Enregistrer'> Envoyer <i class='material-icons right'>send</i> </button>
		</li>
	</ul>
	</form>
	</div>";
?>

<script>
	$(".js-range-slider").ionRangeSlider({
		skin: "round"
	});
</script>