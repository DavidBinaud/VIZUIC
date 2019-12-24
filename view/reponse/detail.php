<?php

    $idReponse = htmlspecialchars($tab_r->get('idReponse'));
    $nomReponse = htmlspecialchars($tab_r->get('nomReponse'));
    $idFormulaire = htmlspecialchars($tab_r->get('idFormulaire'));

	$idFormulaire = $_GET['idFormulaire'];
    echo '
    <div class="container">
    <form method="get" action="./index.php">
    		<input type="hidden" name="action" value="updated"/>
    		<input type="hidden" name="controller" value="reponse"/>
    		<input type="hidden" name="idFormulaire" value="' . $idFormulaire . '"/>
    		<input type="hidden" name="idReponse" value="' . $idReponse . '"/>
    		<ul class ="collection">
    		<li class="collection-item">
    		<span class="formExtLegend"> Formulaire de VIZUIC </span>
    		</li>';

    		echo "
    		<li class='collection-item'>
    		<input type='text' name='nomReponse' id='type_id' placeholder='Inserer un titre' value='". $nomReponse ."' disabled='disabled'/>
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


				    	$type = "text";

				    	echo "<p>
			      				<input placeholder = 'Max : {$q->get('valeurMaxChamp')}' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' pattern='[0-9]' value='{$q->get('valeurChamp')}' disabled='disabled'/>
			    			</p>";
			    	} else if($q->get("typeChamp") == "echelle"){
				    	$type = "radio";
					    
				    	$x = $q->get("valeurMaxChamp");

				    	if ($x > 10) {
				    			echo"<input type='text' class='js-range-slider' name='{$q->get('idChamp')}' data-min='1' data-max='" . $x . "' data-from='{$q->get('valeurChamp')}' value='' />";
				    	} else {

				    		echo "<div class='box'>";

						for ($i=1; $i <= $x; $i++) { 

							if (strcmp ( $i , $q->get('valeurChamp') ) == 0 ) {
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
        								<input type='$type' name='{$q->get('idChamp')}'  value='$i' required disabled='disabled'/>
        								<span>$i</span>
      								</label>
      								</p>";
								
							}
						}
						echo "</div>";
							
					}						

				    } else {
				    	$type = "text";
				    	echo "
				    		<p>
			      				<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' value='{$q->get('valeurChamp')}' disabled='disabled'/>
			    			</p>";
				    }
					
			 	echo "</li>";	
			}
		} else {
			echo "Il n'y a pas de questions";
		}
	
	echo "
	</ul>
	</form>
	</div>";
?>

<script>
	$(".js-range-slider").ionRangeSlider({
		skin: "round"
	});
</script>



