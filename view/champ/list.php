<?php
    echo '
    <form method="get" action="">
    	<fieldset>
    		<input type="hidden" name="action" value="error.php"/>
    		<input type="hidden" name="controller" value="formulaire"/>
    		<input type="hidden" name="idFormulaire" value=$idFormulaire/>
    		<legend> Formulaire de VIZUIC : </legend>';

    		foreach ($tab_q as $q){
    			$nomChamp = htmlspecialchars($q->get("nomChamp"));
    			echo "
    		<fieldset>
	    		<legend>Question {$q->get('idChamp')}:</legend>
			    <p>
			    	<strong>
			      		{$nomChamp}
			      	</strong>
			    </p>";

				    if($q->get("typeChamp") == "nombre"){
				    	$type = "text";

				    	echo "<div class='box'>
								<div>
									<div class='radiobox'>
										<label for='type_id'>$i</label>
									</div>
									<div>
										<input placeholder = 'Exemple : 10' type=" . $type . " name='{$q->get('idChamp')}' id='type_id' value='valeurChamp' pattern='[0-9]' required/>
									</div>
								</div>";
							}

						echo "
						</div>";

					if($q->get("typeChamp") == "echelle"){
				    	$type = "radio";

				    	echo "<div class='box'>";

				    	
				    	$x = $q->get("valeurMaxChamp");

							for ($i=1; $i < $x; $i++) { 
								echo "
								<div>
									<div class='radiobox'>
										<label for='type_id'>$i</label>
									</div>
									<div>
										<input type=" . $type . " name='{$q->get('idChamp')}' id='type_id' value='$i' required/>
									</div>
								</div>";
							}

						echo "
						</div>";

				    }
				    
				    else {
				    	$type = "text";
				    	echo "
				    		<p>
			      				<input placeholder = 'Exemple : Je suis pour' type=" . $type . " name='{$q->get('idChamp')}' id='type_id' required/>
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