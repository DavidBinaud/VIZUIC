<?php
	
	if(strcmp($_GET['action'], 'update')==0){
		$action='readAll';
		$controller='formulaire';
		echo "<a class='btn-flat waves-effect' href='./index.php?action=update&controller=formulaire&idFormulaire={$idFormulaire}'><i class='material-icons blue-text blue-accent-3'>arrow_back</i></a>";
	} else{
		$action = 'created';
		$controller = 'reponse';
		echo "<a class='btn-flat waves-effect' href='index.php?action=readAll&controller=formulaire&gestion=0'><i class='material-icons blue-text blue-accent-3'>arrow_back</i></a>";
	}

    echo '
    <div class="container">
    <form method="get" action="./index.php">
    		<input type="hidden" name="action" value="' . $action . '"/>
    		<input type="hidden" name="controller" value="'. $controller . '"/>
    		<input type="hidden" name="idFormulaire" value="' . $idFormulaire . '"/>
    		<ul class ="collection">
    		<li class="collection-item">
    		<span class="formExtLegend"> Formulaire de VIZUIC </span>
    		</li>';

    		if($gestion == 1) {

    			$cpt = 1;

    			if ($tab_q != NULL) {
    		
    		
    				foreach ($tab_q as $q){
    				
    					$nomChamp = htmlspecialchars($q->get("nomChamp"));
    					echo "<li class='collection-item'>
    					<span class='formIntLegend' >" . $cpt++ . "</span>";
	
    					if($q->get("contexte") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			    	  					{$q->get("contexte")}
			    	  				</strong>
			    				</p>";
			    		}


			    		if($q->get("contexteImage") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			      						{$q->get("contexteImage")}
			      					</strong>
			    				</p>";
			    		}

			    		echo "<p class='formSpaceChamp'>
			    				<strong>
			    					{$nomChamp}
			    				</strong>
			    			</p>";
			    	
			    		if($q->get("instructionReponse") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			      						{$q->get("instructionReponse")}
			      					</strong>
			    				</p>";
			    		}

				    	if($q->get("typeChamp") == "nombre"){

				    		$type = "number";

				    		echo "<p>
			      					<input placeholder = 'Max : {$q->get('valeurMaxChamp')}' type='" . $type . "' name='{$q->get('idChamp')}' id='{$q->get('idChamp')}' min='0' max='" . $q->get('valeurMaxChamp') . "' step='0.01' required disabled='disabled'/>
			    				</p>";
			    		} else if($q->get("typeChamp") == "echelle"){
				    		$type = "radio";
				    
				    		$x = $q->get("valeurMaxChamp");

				    		if ($x > 10) {
				    			echo"<input type='text' class='js-range-slider' name='{$q->get('idChamp')}' data-min='1' data-max='" . $x . "' data-from'1' value='' disabled/>";
				    		} else {
				    			echo "<div class='box'>";

								for ($i=1; $i <= $x; $i++) { 
									echo "
									<p>
									<label>
        								<input type='$type' name='{$q->get('idChamp')}'  value='$i' required disabled='disabled'/>
        								<span>$i</span>
      								</label>
      								</p>";
								
								}
								echo "</div>";
							}

							

				    	} else {
				    	
				    		$type = "text";
				    		echo "
				    			<p>
			      					<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='{$q->get('idChamp')}' id='{$q->get('idChamp')}' required disabled='disabled'/>
			    				</p>";
				    	}

				    	echo"
				  			<a href='./index.php?action=update&controller=champ&idChamp={$q->get('idChamp')}&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons blue-text text-accent-3'>edit</i></a>
			   				<a href='./index.php?action=delete&controller=champ&idChamp={$q->get('idChamp')}&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons blue-text text-accent-3'>clear</i></a>";
			   		}
			   	}

			   	echo"<li class='collection-item'>
							<button class='waves-effect waves-light btn blue accent-3 right' type='submit' value='Enregistrer'> Envoyer <i class='material-icons right'>send</i> </button>
						</li>
						</ul>";


    		} else {
    			echo "<li class='collection-item'><input type='text' name='nomReponse' placeholder='Inserer un titre' 'requiered/></li>";


    			$cpt = 1;

    			if ($tab_q != NULL) {
    		
    		
    				foreach ($tab_q as $q){
    				
    					$nomChamp = htmlspecialchars($q->get("nomChamp"));
    					echo "<li class='collection-item'>
    						<span class='formIntLegend' >" . $cpt++ . "</span>";
	
    					if($q->get("contexte") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			    	  					{$q->get("contexte")}
			    	  				</strong>
			    				</p>";
			    		}


			    		if($q->get("contexteImage") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			      						{$q->get("contexteImage")}
			      					</strong>
			    				</p>";
			    		}

			    		echo "<p class='formSpaceChamp'>
			    				<strong>
			    					{$nomChamp}
			    				</strong>
			    			</p>";
			    	
			    		if($q->get("instructionReponse") != NULL){
			    			echo "<p class='formSpaceChamp'>
			    					<strong>
			      						{$q->get("instructionReponse")}
			      					</strong>
			    				</p>";
			    		}

				    	if($q->get("typeChamp") == "nombre"){

				    		$type = "number";

				    		echo "<p>
			      					<input placeholder = 'Max : {$q->get('valeurMaxChamp')}' type='" . $type . "' name='{$q->get('idChamp')}' id='{$q->get('idChamp')}' min='0' max='" . $q->get('valeurMaxChamp') . "' step='0.01' required/>
			    				</p>";
			    		} else if($q->get("typeChamp") == "echelle"){
				    		$type = "radio";
				    
					    	$x = $q->get("valeurMaxChamp");
					    	if ($x > 10) {
					    		echo"<input type='text' class='js-range-slider' name='{$q->get('idChamp')}' data-min='1' data-max='" . $x . "' data-from'1' value='' />";
					    	} else {
					    		echo "<div class='box'>";

								for ($i=1; $i <= $x; $i++) { 
									echo "
									<p>
									<label>
        								<input type='$type' name='{$q->get('idChamp')}'  value='$i' required/>
        								<span>$i</span>
      								</label>
      								<p>";
								
								}

								echo"</div>";
							}	

				    	} else {
				    		$type = "text";
				    		echo "
				    			<p>
			      					<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='{$q->get('idChamp')}' id='{$q->get('idChamp')}' required/>
			    				</p>";
				    	}
				  		
			 			echo "</li>";	
					}

					echo"
						<li class='collection-item'>
							<button class='waves-effect waves-light btn blue accent-3 right' type='submit' value='Enregistrer'> Envoyer <i class='material-icons right'>send</i> </button>
						</li>
						</ul>";
				} else {
					echo "Il n'y a pas de questions";
				}
			}

	
	echo "
	</form>
	</div>";

	if ($gestion==1) {
		echo"<div class='fixed-action-btn'><a href='index.php?action=create&controller=champ&idFormulaire=" . rawurlencode($idFormulaire) . "' class='btn-floating btn-large waves-effect waves-light pulse white'><i class='large material-icons blue-text text-accent-3'>add</i></a></div>";
	}
?>

<script>
	$(".js-range-slider").ionRangeSlider({
		skin: "round"
	});
</script>