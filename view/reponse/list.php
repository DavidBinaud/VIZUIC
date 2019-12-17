<?php
	echo '<h3 class="titreListForm"> Liste des réponses	 <br> </h3>';
    
		foreach ($tab_r as $r) {
    		echo "<div class = 'card'>
   					<div class='card-content'> Réponse :  

   						<p>
   						<a class='nomForm' href='index.php?action=update&controller=reponse&gestion=0&idFormulaire=" . $r->get('idFormulaire') . "&idReponse=" . $r->get('idReponse') . "'>" . $r->get('nomReponse') . "</a> </p>
					
						<p>
						<a class='waves-effect waves-light btn blue lighten-1' href='./index.php?action=update&controller=reponse&idReponse={$r->get('idReponse')}&idFormulaire={$r->get('idFormulaire')}'>Modifier</a>

						<a class='waves-effect waves-light btn blue lighten-1' href='./index.php?action=delete&controller=reponse&idReponse={$r->get('idReponse')}&idFormulaire={$r->get('idFormulaire')}'>Supprimer</a>
						</p>
					</div>
				</div>";
		} 	
?>