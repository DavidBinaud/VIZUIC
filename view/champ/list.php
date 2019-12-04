<?php
    echo '
    <form method="get" action="">
    	<fieldset class ="formExt">
    		<input type="hidden" name="action" value="save"/>
    		<input type="hidden" name="controller" value="formulaire"/>
    		<input type="hidden" name="idFormulaire" value="' . $_GET['idFormulaire'] . '"/>
    		<legend class="formExtLegend"> Formulaire de VIZUIC </legend>';
    		
    		$cpt = 1;

    		foreach ($tab_q as $q){
    			
    			$nomChamp = htmlspecialchars($q->get("nomChamp"));
    			echo "
    		<fieldset class='formInt'>
	    		<legend class='formIntLegend' >Question " . $cpt++ . ":</legend>
			    <p class='formSpaceChamp'>
			    	<strong>
			      		{$nomChamp}
			      	</strong>
			    </p>";

				    if($q->get("typeChamp") == "nombre"){


				    	$type = "text";

				    	echo "<p>
			      				<input placeholder = 'Exemple : 10' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' pattern='[0-9]' required/>
			    			</p>";
			    	} else if($q->get("typeChamp") == "echelle"){
				    	$type = "radio";

				    	echo "<div class='box'>";

				    	
				    	$x = $q->get("valeurMaxChamp");

							for ($i=1; $i <= $x; $i++) { 
								echo "
								<div class='radiobox'>
									<label for='type_id'>$i</label>
								</div>
								<label>
        							<input type='$type' name='{$q->get('idChamp')}'  value='$i' id='type_id' required/>
        							<span></span>
      							</label>";
								
							}

						echo "
						</div>";

				    }
				    
				    else {
				    	$type = "text";
				    	echo "
				    		<p>
			      				<input placeholder = 'Exemple : Je suis pour' type='" . $type . "' name='{$q->get('idChamp')}' id='type_id' required/>
			    			</p>";
				    }	

			    	if ($gestion == 1) {
				  		echo"
			   		<button>
			   			<a href='./index.php?action=delete&controller=champ&idChamp={$q->get('idChamp')}'>Supprimer</a>
			   		</button>
			   		<button>
			   			<a href='./index.php?action=update&controller=champ&idChamp={$q->get('idChamp')}'>Mettre à Jour</a>
			   		</button>";
				  	}
			 	echo "</fieldset>";	
			}
	echo '
	</fieldset>
	<p>
		<input type="submit" value="Envoyer" />
	</p>
	</form>';
?>